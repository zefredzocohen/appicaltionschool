/*
  html2canvas 0.4.1 <http://html2canvas.hertzen.com>
  Copyright (c) 2013 Niklas von Hertzen

  Released under MIT License
*/

(function(window, document, undefined){

"use strict";

var _html2canvas = {},
previousElement,
computedCSS,
html2canvas;

_html2canvas.Util = {};

_html2canvas.Util.log = function(a) {
  if (_html2canvas.logging && window.console && window.console.log) {
    window.console.log(a);
  }
};

_html2canvas.Util.trimText = (function(isNative){
  return function(input) {
    return isNative ? isNative.apply(input) : ((input || '') + '').replace( /^\s+|\s+$/g , '' );
  };
})(String.prototype.trim);

_html2canvas.Util.asFloat = function(v) {
  return parseFloat(v);
};

(function() {
  // TODO: support all possible length values
  var TEXT_SHADOW_PROPERTY = /((rgba|rgb)\([^\)]+\)(\s-?\d+px){0,})/g;
  var TEXT_SHADOW_VALUES = /(-?\d+px)|(#.+)|(rgb\(.+\))|(rgba\(.+\))/g;
  _html2canvas.Util.parseTextShadows = function (value) {
    if (!value || value === 'none') {
      return [];
    }

    // find multiple shadow declarations
    var shadows = value.match(TEXT_SHADOW_PROPERTY),
      results = [];
    for (var i = 0; shadows && (i < shadows.length); i++) {
      var s = shadows[i].match(TEXT_SHADOW_VALUES);
      results.push({
        color: s[0],
        offsetX: s[1] ? s[1].replace('px', '') : 0,
        offsetY: s[2] ? s[2].replace('px', '') : 0,
        blur: s[3] ? s[3].replace('px', '') : 0
      });
    }
    return results;
  };
})();

_html2canvas.Util.parseBackgroundImage = function (value) {
    var whitespace = ' \r\n\t',
        method, definition, prefix, prefix_i, block, results = [],
        c, mode = 0, numParen = 0, quote, args;

    var appendResult = function(){
        if(method) {
            if(definition.substr( 0, 1 ) === '"') {
                definition = definition.substr( 1, definition.length - 2 );
            }
            if(definition) {
                args.push(definition);
            }
            if(method.substr( 0, 1 ) === '-' &&
                    (prefix_i = method.indexOf( '-', 1 ) + 1) > 0) {
                prefix = method.substr( 0, prefix_i);
                method = method.substr( prefix_i );
            }
            results.push({
                prefix: prefix,
                method: method.toLowerCase(),
                value: block,
                args: args
            });
        }
        args = []; //for some odd reason, setting .length = 0 didn't work in safari
        method =
            prefix =
            definition =
            block = '';
    };

    appendResult();
    for(var i = 0, ii = value.length; i<ii; i++) {
        c = value[i];
        if(mode === 0 && whitespace.indexOf( c ) > -1){
            continue;
        }
        switch(c) {
            case '"':
                if(!quote) {
                    quote = c;
                }
                else if(quote === c) {
                    quote = null;
                }
                break;

            case '(':
                if(quote) { break; }
                else if(mode === 0) {
                    mode = 1;
                    block += c;
                    continue;
                } else {
                    numParen++;
                }
                break;

            case ')':
                if(quote) { break; }
                else if(mode === 1) {
                    if(numParen === 0) {
                        mode = 0;
                        block += c;
                        appendResult();
                        continue;
                    } else {
                        numParen--;
                    }
                }
                break;

            case ',':
                if(quote) { break; }
                else if(mode === 0) {
                    appendResult();
                    continue;
                }
                else if (mode === 1) {
                    if(numParen === 0 && !method.match(/^url$/i)) {
                        args.push(definition);
                        definition = '';
                        block += c;
                        continue;
                    }
                }
                break;
        }

        block += c;
        if(mode === 0) { method += c; }
        else { definition += c; }
    }
    appendResult();

    return results;
};

_html2canvas.Util.Bounds = function (element) {
  var clientRect, bounds = {};

  if (element.getBoundingClientRect){
    clientRect = element.getBoundingClientRect();

    // TODO add scroll position to bounds, so no scrolling of window necessary
    bounds.top = clientRect.top;
    bounds.bottom = clientRect.bottom || (clientRect.top + clientRect.height);
    bounds.left = clientRect.left;

    bounds.width = element.offsetWidth;
    bounds.height = element.offsetHeight;
  }

  return bounds;
};

// TODO ideally, we'd want everything to go through this function instead of Util.Bounds,
// but would require further work to calculate the correct positions for elements with offsetParents
_html2canvas.Util.OffsetBounds = function (element) {
  var parent = element.offsetParent ? _html2canvas.Util.OffsetBounds(element.offsetParent) : {top: 0, left: 0};

  return {
    top: element.offsetTop + parent.top,
    bottom: element.offsetTop + element.offsetHeight + parent.top,
    left: element.offsetLeft + parent.left,
    width: element.offsetWidth,
    height: element.offsetHeight
  };
};

function toPX(element, attribute, value ) {
    var rsLeft = element.runtimeStyle && element.runtimeStyle[attribute],
        left,
        style = element.style;

    // Check if we are not dealing with pixels, (Opera has issues with this)
    // Ported from jQuery css.js
    // From the awesome hack by Dean Edwards
    // http://erik.eae.net/archives/2007/07/27/18.54.15/#comment-102291

    // If we're not dealing with a regular pixel number
    // but a number that has a weird ending, we need to convert it to pixels

    if ( !/^-?[0-9]+\.?[0-9]*(?:px)?$/i.test( value ) && /^-?\d/.test(value) ) {
        // Remember the original values
        left = style.left;

        // Put in the new values to get a computed value out
        if (rsLeft) {
            element.runtimeStyle.left = element.currentStyle.left;
        }
        style.left = attribute === "fontSize" ? "1em" : (value || 0);
        value = style.pixelLeft + "px";

        // Revert the changed values
        style.left = left;
        if (rsLeft) {
            element.runtimeStyle.left = rsLeft;
        }
    }

    if (!/^(thin|medium|thick)$/i.test(value)) {
        return Math.round(parseFloat(value)) + "px";
    }

    return value;
}

function asInt(val) {
    return parseInt(val, 10);
}

function isPercentage(value) {
  return value.toString().indexOf("%") !== -1;
}

function parseBackgroundSizePosition(value, element, attribute, index) {
    value = (value || '').split(',');
    value = value[index || 0] || value[0] || 'auto';
    value = _html2canvas.Util.trimText(value).split(' ');
    if(attribute === 'backgroundSize' && (value[0] && value[0].match(/^(cover|contain|auto)$/))) {
        return value;
    } else {
        value[0] = (value[0].indexOf( "%" ) === -1) ? toPX(element, attribute + "X", value[0]) : value[0];
        if(value[1] === undefined) {
            if(attribute === 'backgroundSize') {
                value[1] = 'auto';
                return value;
            } else {
                // IE 9 doesn't return double digit always
                value[1] = value[0];
            }
        }
        value[1] = (value[1].indexOf("%") === -1) ? toPX(element, attribute + "Y", value[1]) : value[1];
    }
    return value;
}

_html2canvas.Util.getCSS = function (element, attribute, index) {
    if (previousElement !== element) {
      computedCSS = document.defaultView.getComputedStyle(element, null);
    }

    var value = computedCSS[attribute];

    if (/^background(Size|Position)$/.test(attribute)) {
        return parseBackgroundSizePosition(value, element, attribute, index);
    } else if (/border(Top|Bottom)(Left|Right)Radius/.test(attribute)) {
      var arr = value.split(" ");
      if (arr.length <= 1) {
          arr[1] = arr[0];
      }
      return arr.map(asInt);
    }

  return value;
};

_html2canvas.Util.resizeBounds = function( current_width, current_height, target_width, target_height, stretch_mode ){
  var target_ratio = target_width / target_height,
    current_ratio = current_width / current_height,
    output_width, output_height;

  if(!stretch_mode || stretch_mode === 'auto') {
    output_width = target_width;
    output_height = target_height;
  } else if(target_ratio < current_ratio ^ stretch_mode === 'contain') {
    output_height = target_height;
    output_width = target_height * current_ratio;
  } else {
    output_width = target_width;
    output_height = target_width / current_ratio;
  }

  return {
    width: output_width,
    height: output_height
  };
};

_html2canvas.Util.BackgroundPosition = function(element, bounds, image, imageIndex, backgroundSize ) {
    var backgroundPosition =  _html2canvas.Util.getCSS(element, 'backgroundPosition', imageIndex),
        leftPosition,
        topPosition;
    if (backgroundPosition.length === 1){
        backgroundPosition = [backgroundPosition[0], backgroundPosition[0]];
    }

    if (isPercentage(backgroundPosition[0])){
        leftPosition = (bounds.width - (backgroundSize || image).width) * (parseFloat(backgroundPosition[0]) / 100);
    } else {
        leftPosition = parseInt(backgroundPosition[0], 10);
    }

    if (backgroundPosition[1] === 'auto') {
        topPosition = leftPosition / image.width * image.height;
    } else if (isPercentage(backgroundPosition[1])){
        topPosition =  (bounds.height - (backgroundSize || image).height) * parseFloat(backgroundPosition[1]) / 100;
    } else {
        topPosition = parseInt(backgroundPosition[1], 10);
    }

    if (backgroundPosition[0] === 'auto') {
        leftPosition = topPosition / image.height * image.width;
    }

    return {left: leftPosition, top: topPosition};
};

_html2canvas.Util.BackgroundSize = function(element, bounds, image, imageIndex) {
  var backgroundSize =  _html2canvas.Util.getCSS(element, 'backgroundSize', imageIndex), width, height;

  if (backgroundSize.length === 1) {
    backgroundSize = [backgroundSize[0], backgroundSize[0]];
  }

  if (isPercentage(backgroundSize[0])) {
    width = bounds.width * parseFloat(backgroundSize[0]) / 100;
  } else if (/contain|cover/.test(backgroundSize[0])) {
    return _html2canvas.Util.resizeBounds(image.width, image.height, bounds.width, bounds.height, backgroundSize[0]);
  } else {
    width = parseInt(backgroundSize[0], 10);
  }

  if (backgroundSize[0] === 'auto' && backgroundSize[1] === 'auto') {
    height = image.height;
  } else if (backgroundSize[1] === 'auto') {
    height = width / image.width * image.height;
  } else if (isPercentage(backgroundSize[1])) {
    height =  bounds.height * parseFloat(backgroundSize[1]) / 100;
  } else {
    height = parseInt(backgroundSize[1], 10);
  }

  if (backgroundSize[0] === 'auto') {
    width = height / image.height * image.width;
  }

  return {width: width, height: height};
};

_html2canvas.Util.BackgroundRepeat = function(element, imageIndex) {
  var backgroundRepeat = _html2canvas.Util.getCSS(element, "backgroundRepeat").split(",").map(_html2canvas.Util.trimText);
  return backgroundRepeat[imageIndex] || backgroundRepeat[0];
};

_html2canvas.Util.Extend = function (options, defaults) {
  for (var key in options) {
    if (options.hasOwnProperty(key)) {
      defaults[key] = options[key];
    }
  }
  return defaults;
};


/*
 * Derived from jQuery.contents()
 * Copyright 2010, John Resig
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 */
_html2canvas.Util.Children = function( elem ) {
  var children;
  try {
    children = (elem.nodeName && elem.nodeName.toUpperCase() === "IFRAME") ? elem.contentDocument || elem.contentWindow.document : (function(array) {
      var ret = [];
      if (array !== null) {
        (function(first, second ) {
          var i = first.length,
          j = 0;

          if (typeof second.length === "number") {
            for (var l = second.length; j < l; j++) {
              first[i++] = second[j];
            }
          } else {
            while (second[j] !== undefined) {
              first[i++] = second[j++];
            }
          }

          first.length = i;

          return first;
        })(ret, array);
      }
      return ret;
    })(elem.childNodes);

  } catch (ex) {
    _html2canvas.Util.log("html2canvas.Util.Children failed with exception: " + ex.message);
    children = [];
  }
  return children;
};

_html2canvas.Util.isTransparent = function(backgroundColor) {
  return (!backgroundColor || backgroundColor === "transparent" || backgroundColor === "rgba(0, 0, 0, 0)");
};

_html2canvas.Util.Font = (function () {

  var fontData = {};

  return function(font, fontSize, doc) {
    if (fontData[font + "-" + fontSize] !== undefined) {
      return fontData[font + "-" + fontSize];
    }

    var container = doc.createElement('div'),
    img = doc.createElement('img'),
    span = doc.createElement('span'),
    sampleText = 'Hidden Text',
    baseline,
    middle,
    metricsObj;

    container.style.visibility = "hidden";
    container.style.fontFamily = font;
    container.style.fontSize = fontSize;
    container.style.margin = 0;
    container.style.padding = 0;

    doc.body.appendChild(container);

    // http://probablyprogramming.com/2009/03/15/the-tiniest-gif-ever (handtinywhite.gif)
    img.src = "data:image/gif;base64,R0lGODlhAQABAIABAP///wAAACwAAAAAAQABAAACAkQBADs=";
    img.width = 1;
    img.height = 1;

    img.style.margin = 0;
    img.style.padding = 0;
    img.style.verticalAlign = "baseline";

    span.style.fontFamily = font;
    span.style.fontSize = fontSize;
    span.style.margin = 0;
    span.style.padding = 0;

    span.appendChild(doc.createTextNode(sampleText));
    container.appendChild(span);
    container.appendChild(img);
    baseline = (img.offsetTop - span.offsetTop) + 1;

    container.removeChild(span);
    container.appendChild(doc.createTextNode(sampleText));

    container.style.lineHeight = "normal";
    img.style.verticalAlign = "super";

    middle = (img.offsetTop-container.offsetTop) + 1;
    metricsObj = {
      baseline: baseline,
      lineWidth: 1,
      middle: middle
    };

    fontData[font + "-" + fontSize] = metricsObj;

    doc.body.removeChild(container);

    return metricsObj;
  };
})();

(function(){
  var Util = _html2canvas.Util,
    Generate = {};

  _html2canvas.Generate = Generate;

  var reGradients = [
  /^(-webkit-linear-gradient)\(([a-z\s]+)([\w\d\.\s,%\(\)]+)\)$/,
  /^(-o-linear-gradient)\(([a-z\s]+)([\w\d\.\s,%\(\)]+)\)$/,
  /^(-webkit-gradient)\((linear|radial),\s((?:\d{1,3}%?)\s(?:\d{1,3}%?),\s(?:\d{1,3}%?)\s(?:\d{1,3}%?))([\w\d\.\s,%\(\)\-]+)\)$/,
  /^(-moz-linear-gradient)\(((?:\d{1,3}%?)\s(?:\d{1,3}%?))([\w\d\.\s,%\(\)]+)\)$/,
  /^(-webkit-radial-gradient)\(((?:\d{1,3}%?)\s(?:\d{1,3}%?)),\s(\w+)\s([a-z\-]+)([\w\d\.\s,%\(\)]+)\)$/,
  /^(-moz-radial-gradient)\(((?:\d{1,3}%?)\s(?:\d{1,3}%?)),\s(\w+)\s?([a-z\-]*)([\w\d\.\s,%\(\)]+)\)$/,
  /^(-o-radial-gradient)\(((?:\d{1,3}%?)\s(?:\d{1,3}%?)),\s(\w+)\s([a-z\-]+)([\w\d\.\s,%\(\)]+)\)$/
  ];

  /*
 * TODO: Add IE10 vendor prefix (-ms) support
 * TODO: Add W3C gradient (linear-gradient) support
 * TODO: Add old Webkit -webkit-gradient(radial, ...) support
 * TODO: Maybe some RegExp optimizations are possible ;o)
 */
  Generate.parseGradient = function(css, bounds) {
    var gradient, i, len = reGradients.length, m1, stop, m2, m2Len, step, m3, tl,tr,br,bl;

    for(i = 0; i < len; i+=1){
      m1 = css.match(reGradients[i]);
      if(m1) {
        break;
      }
    }

    if(m1) {
      switch(m1[1]) {
        case '-webkit-linear-gradient':
        case '-o-linear-gradient':

          gradient = {
            type: 'linear',
            x0: null,
            y0: null,
            x1: null,
            y1: null,
            colorStops: []
          };

          // get coordinates
          m2 = m1[2].match(/\w+/g);
          if(m2){
            m2Len = m2.length;
            for(i = 0; i < m2Len; i+=1){
              switch(m2[i]) {
                case 'top':
                  gradient.y0 = 0;
                  gradient.y1 = bounds.height;
                  break;

                case 'right':
                  gradient.x0 = bounds.width;
                  gradient.x1 = 0;
                  break;

                case 'bottom':
                  gradient.y0 = bounds.height;
                  gradient.y1 = 0;
                  break;

                case 'left':
                  gradient.x0 = 0;
                  gradient.x1 = bounds.width;
                  break;
              }
            }
          }
          if(gradient.x0 === null && gradient.x1 === null){ // center
            gradient.x0 = gradient.x1 = bounds.width / 2;
          }
          if(gradient.y0 === null && gradient.y1 === null){ // center
            gradient.y0 = gradient.y1 = bounds.height / 2;
          }

          // get colors and stops
          m2 = m1[3].match(/((?:rgb|rgba)\(\d{1,3},\s\d{1,3},\s\d{1,3}(?:,\s[0-9\.]+)?\)(?:\s\d{1,3}(?:%|px))?)+/g);
          if(m2){
            m2Len = m2.length;
            step = 1 / Math.max(m2Len - 1, 1);
            for(i = 0; i < m2Len; i+=1){
              m3 = m2[i].match(/((?:rgb|rgba)\(\d{1,3},\s\d{1,3},\s\d{1,3}(?:,\s[0-9\.]+)?\))\s*(\d{1,3})?(%|px)?/);
              if(m3[2]){
                stop = parseFloat(m3[2]);
                if(m3[3] === '%'){
                  stop /= 100;
                } else { // px - stupid opera
                  stop /= bounds.width;
                }
              } else {
                stop = i * step;
              }
              gradient.colorStops.push({
                color: m3[1],
                stop: stop
              });
            }
          }
          break;

        case '-webkit-gradient':

          gradient = {
            type: m1[2] === 'radial' ? 'circle' : m1[2], // TODO: Add radial gradient support for older mozilla definitions
            x0: 0,
            y0: 0,
            x1: 0,
            y1: 0,
            colorStops: []
          };

          // get coordinates
          m2 = m1[3].match(/(\d{1,3})%?\s(\d{1,3})%?,\s(\d{1,3})%?\s(\d{1,3})%?/);
          if(m2){
            gradient.x0 = (m2[1] * bounds.width) / 100;
            gradient.y0 = (m2[2] * bounds.height) / 100;
            gradient.x1 = (m2[3] * bounds.width) / 100;
            gradient.y1 = (m2[4] * bounds.height) / 100;
          }

          // get colors and stops
          m2 = m1[4].match(/((?:from|to|color-stop)\((?:[0-9\.]+,\s)?(?:rgb|rgba)\(\d{1,3},\s\d{1,3},\s\d{1,3}(?:,\s[0-9\.]+)?\)\))+/g);
          if(m2){
            m2Len = m2.length;
            for(i = 0; i < m2Len; i+=1){
              m3 = m2[i].match(/(from|to|color-stop)\(([0-9\.]+)?(?:,\s)?((?:rgb|rgba)\(\d{1,3},\s\d{1,3},\s\d{1,3}(?:,\s[0-9\.]+)?\))\)/);
              stop = parseFloat(m3[2]);
              if(m3[1] === 'from') {
                stop = 0.0;
              }
              if(m3[1] === 'to') {
                stop = 1.0;
              }
              gradient.colorStops.push({
                color: m3[3],
                stop: stop
              });
            }
          }
          break;

        case '-moz-linear-gradient':

          gradient = {
            type: 'linear',
            x0: 0,
            y0: 0,
            x1: 0,
            y1: 0,
            colorStops: []
          };

          // get coordinates
          m2 = m1[2].match(/(\d{1,3})%?\s(\d{1,3})%?/);

          // m2[1] == 0%   -> left
          // m2[1] == 50%  -> center
          // m2[1] == 100% -> right

          // m2[2] == 0%   -> top
          // m2[2] == 50%  -> center
          // m2[2] == 100% -> bottom

          if(m2){
            gradient.x0 = (m2[1] * bounds.width) / 100;
            gradient.y0 = (m2[2] * bounds.height) / 100;
            gradient.x1 = bounds.width - gradient.x0;
            gradient.y1 = bounds.height - gradient.y0;
          }

          // get colors and stops
          m2 = m1[3].match(/((?:rgb|rgba)\(\d{1,3},\s\d{1,3},\s\d{1,3}(?:,\s[0-9\.]+)?\)(?:\s\d{1,3}%)?)+/g);
          if(m2){
            m2Len = m2.length;
            step = 1 / Math.max(m2Len - 1, 1);
            for(i = 0; i < m2Len; i+=1){
              m3 = m2[i].match(/((?:rgb|rgba)\(\d{1,3},\s\d{1,3},\s\d{1,3}(?:,\s[0-9\.]+)?\))\s*(\d{1,3})?(%)?/);
              if(m3[2]){
                stop = parseFloat(m3[2]);
                if(m3[3]){ // percentage
                  stop /= 100;
                }
              } else {
                stop = i * step;
              }
              gradient.colorStops.push({
                color: m3[1],
                stop: stop
              });
            }
          }
          break;

        case '-webkit-radial-gradient':
        case '-moz-radial-gradient':
        case '-o-radial-gradient':

          gradient = {
            type: 'circle',
            x0: 0,
            y0: 0,
            x1: bounds.width,
            y1: bounds.height,
            cx: 0,
            cy: 0,
            rx: 0,
            ry: 0,
            colorStops: []
          };

          // center
          m2 = m1[2].match(/(\d{1,3})%?\s(\d{1,3})%?/);
          if(m2){
            gradient.cx = (m2[1] * bounds.width) / 100;
            gradient.cy = (m2[2] * bounds.height) / 100;
          }

          // size
          m2 = m1[3].match(/\w+/);
          m3 = m1[4].match(/[a-z\-]*/);
          if(m2 && m3){
            switch(m3[0]){
              case 'farthest-corner':
              case 'cover': // is equivalent to farthest-corner
              case '': // mozilla removes "cover" from definition :(
                tl = Math.sqrt(Math.pow(gradient.cx, 2) + Math.pow(gradient.cy, 2));
                tr = Math.sqrt(Math.pow(gradient.cx, 2) + Math.pow(gradient.y1 - gradient.cy, 2));
                br = Math.sqrt(Math.pow(gradient.x1 - gradient.cx, 2) + Math.pow(gradient.y1 - gradient.cy, 2));
                bl = Math.sqrt(Math.pow(gradient.x1 - gradient.cx, 2) + Math.pow(gradient.cy, 2));
                gradient.rx = gradient.ry = Math.max(tl, tr, br, bl);
                break;
              case 'closest-corner':
                tl = Math.sqrt(Math.pow(gradient.cx, 2) + Math.pow(gradient.cy, 2));
                tr = Math.sqrt(Math.pow(gradient.cx, 2) + Math.pow(gradient.y1 - gradient.cy, 2));
                br = Math.sqrt(Math.pow(gradient.x1 - gradient.cx, 2) + Math.pow(gradient.y1 - gradient.cy, 2));
                bl = Math.sqrt(Math.pow(gradient.x1 - gradient.cx, 2) + Math.pow(gradient.cy, 2));
                gradient.rx = gradient.ry = Math.min(tl, tr, br, bl);
                break;
              case 'farthest-side':
                if(m2[0] === 'circle'){
                  gradient.rx = gradient.ry = Math.max(
                    gradient.cx,
                    gradient.cy,
                    gradient.x1 - gradient.cx,
                    gradient.y1 - gradient.cy
                    );
                } else { // ellipse

                  gradient.type = m2[0];

                  gradient.rx = Math.max(
                    gradient.cx,
                    gradient.x1 - gradient.cx
                    );
                  gradient.ry = Math.max(
                    gradient.cy,
                    gradient.y1 - gradient.cy
                    );
                }
                break;
              case 'closest-side':
              case 'contain': // is equivalent to closest-side
                if(m2[0] === 'circle'){
                  gradient.rx = gradient.ry = Math.min(
                    gradient.cx,
                    gradient.cy,
                    gradient.x1 - gradient.cx,
                    gradient.y1 - gradient.cy
                    );
                } else { // ellipse

                  gradient.type = m2[0];

                  gradient.rx = Math.min(
                    gradient.cx,
                    gradient.x1 - gradient.cx
                    );
                  gradient.ry = Math.min(
                    gradient.cy,
                    gradient.y1 - gradient.cy
                    );
                }
                break;

            // TODO: add support for "30px 40px" sizes (webkit only)
            }
          }

          // color stops
          m2 = m1[5].match(/((?:rgb|rgba)\(\d{1,3},\s\d{1,3},\s\d{1,3}(?:,\s[0-9\.]+)?\)(?:\s\d{1,3}(?:%|px))?)+/g);
          if(m2){
            m2Len = m2.length;
            step = 1 / Math.max(m2Len - 1, 1);
            for(i = 0; i < m2Len; i+=1){
              m3 = m2[i].match(/((?:rgb|rgba)\(\d{1,3},\s\d{1,3},\s\d{1,3}(?:,\s[0-9\.]+)?\))\s*(\d{1,3})?(%|px)?/);
              if(m3[2]){
                stop = parseFloat(m3[2]);
                if(m3[3] === '%'){
                  stop /= 100;
                } else { // px - stupid opera
                  stop /= bounds.width;
                }
              } else {
                stop = i * step;
              }
              gradient.colorStops.push({
                color: m3[1],
                stop: stop
              });
            }
          }
          break;
      }
    }

    return gradient;
  };

  function addScrollStops(grad) {
    return function(colorStop) {
      try {
        grad.addColorStop(colorStop.stop, colorStop.color);
      }
      catch(e) {
        Util.log(['failed to add color stop: ', e, '; tried to add: ', colorStop]);
      }
    };
  }

  Generate.Gradient = function(src, bounds) {
    if(bounds.width === 0 || bounds.height === 0) {
      return;
    }

    var canvas = document.createElement('canvas'),
    ctx = canvas.getContext('2d'),
    gradient, grad;

    canvas.width = bounds.width;
    canvas.height = bounds.height;

    // TODO: add support for multi defined background gradients
    gradient = _html2canvas.Generate.parseGradient(src, bounds);

    if(gradient) {
      switch(gradient.type) {
        case 'linear':
          grad = ctx.createLinearGradient(gradient.x0, gradient.y0, gradient.x1, gradient.y1);
          gradient.colorStops.forEach(addScrollStops(grad));
          ctx.fillStyle = grad;
          ctx.fillRect(0, 0, bounds.width, bounds.height);
          break;

        case 'circle':
          grad = ctx.createRadialGradient(gradient.cx, gradient.cy, 0, gradient.cx, gradient.cy, gradient.rx);
          gradient.colorStops.forEach(addScrollStops(grad));
          ctx.fillStyle = grad;
          ctx.fillRect(0, 0, bounds.width, bounds.height);
          break;

        case 'ellipse':
          var canvasRadial = document.createElement('canvas'),
            ctxRadial = canvasRadial.getContext('2d'),
            ri = Math.max(gradient.rx, gradient.ry),
            di = ri * 2;

          canvasRadial.width = canvasRadial.height = di;

          grad = ctxRadial.createRadialGradient(gradient.rx, gradient.ry, 0, gradient.rx, gradient.ry, ri);
          gradient.colorStops.forEach(addScrollStops(grad));

          ctxRadial.fillStyle = grad;
          ctxRadial.fillRect(0, 0, di, di);

          ctx.fillStyle = gradient.colorStops[gradient.colorStops.length - 1].color;
          ctx.fillRect(0, 0, canvas.width, canvas.height);
          ctx.drawImage(canvasRadial, gradient.cx - gradient.rx, gradient.cy - gradient.ry, 2 * gradient.rx, 2 * gradient.ry);
          break;
      }
    }

    return canvas;
  };

  Generate.ListAlpha = function(number) {
    var tmp = "",
    modulus;

    do {
      modulus = number % 26;
      tmp = String.fromCharCode((modulus) + 64) + tmp;
      number = number / 26;
    }while((number*26) > 26);

    return tmp;
  };

  Generate.ListRoman = function(number) {
    var romanArray = ["M", "CM", "D", "CD", "C", "XC", "L", "XL", "X", "IX", "V", "IV", "I"],
    decimal = [1000, 900, 500, 400, 100, 90, 50, 40, 10, 9, 5, 4, 1],
    roman = "",
    v,
    len = romanArray.length;

    if (number <= 0 || number >= 4000) {
      return number;
    }

    for (v=0; v < len; v+=1) {
      while (number >= decimal[v]) {
        number -= decimal[v];
        roman += romanArray[v];
      }
    }

    return roman;
  };
})();
function h2cRenderContext(width, height) {
  var storage = [];
  return {
    storage: storage,
    width: width,
    height: height,
    clip: function() {
      storage.push({
        type: "function",
        name: "clip",
        'arguments': arguments
      });
    },
    translate: function() {
      storage.push({
        type: "function",
        name: "translate",
        'arguments': arguments
      });
    },
    fill: function() {
      storage.push({
        type: "function",
        name: "fill",
        'arguments': arguments
      });
    },
    save: function() {
      storage.push({
        type: "function",
        name: "save",
        'arguments': arguments
      });
    },
    restore: function() {
      storage.push({
        type: "function",
        name: "restore",
        'arguments': arguments
      });
    },
    fillRect: function () {
      storage.push({
        type: "function",
        name: "fillRect",
        'arguments': arguments
      });
    },
    createPattern: function() {
      storage.push({
        type: "function",
        name: "createPattern",
        'arguments': arguments
      });
    },
    drawShape: function() {

      var shape = [];

      storage.push({
        type: "function",
        name: "drawShape",
        'arguments': shape
      });

      return {
        moveTo: function() {
          shape.push({
            name: "moveTo",
            'arguments': arguments
          });
        },
        lineTo: function() {
          shape.push({
            name: "lineTo",
            'arguments': arguments
          });
        },
        arcTo: function() {
          shape.push({
            name: "arcTo",
            'arguments': arguments
          });
        },
        bezierCurveTo: function() {
          shape.push({
            name: "bezierCurveTo",
            'arguments': arguments
          });
        },
        quadraticCurveTo: function() {
          shape.push({
            name: "quadraticCurveTo",
            'arguments': arguments
          });
        }
      };

    },
    drawImage: function () {
      storage.push({
        type: "function",
        name: "drawImage",
        'arguments': arguments
      });
    },
    fillText: function () {
      storage.push({
        type: "function",
        name: "fillText",
        'arguments': arguments
      });
    },
    setVariable: function (variable, value) {
      storage.push({
        type: "variable",
        name: variable,
        'arguments': value
      });
      return value;
    }
  };
}
_html2canvas.Parse = function (images, options, cb) {
  window.scroll(0,0);

  var element = (( options.elements === undefined ) ? document.body : options.elements[0]), // select body by default
  numDraws = 0,
  doc = element.ownerDocument,
  Util = _html2canvas.Util,
  support = Util.Support(options, doc),
  ignoreElementsRegExp = new RegExp("(" + options.ignoreElements + ")"),
  body = doc.body,
  getCSS = Util.getCSS,
  pseudoHide = "___html2canvas___pseudoelement",
  hidePseudoElementsStyles = doc.createElement('style');

  hidePseudoElementsStyles.innerHTML = '.' + pseudoHide +
  '-parent:before { content: "" !important; display: none !important; }' +
  '.' + pseudoHide + '-parent:after { content: "" !important; display: none !important; }';

  body.appendChild(hidePseudoElementsStyles);

  images = images || {};

  init();

  function init() {
    var background = getCSS(document.documentElement, "backgroundColor"),
      transparentBackground = (Util.isTransparent(background) && element === document.body),
      stack = renderElement(element, null, false, transparentBackground);

    // create pseudo elements in a single pass to prevent synchronous layouts
    addPseudoElements(element);

    parseChildren(element, stack, function() {
      if (transparentBackground) {
        background = stack.backgroundColor;
      }

      removePseudoElements();

      Util.log('Done parsing, moving to Render.');

      cb({
        backgroundColor: background,
        stack: stack
      });
    });
  }

  // Given a root element, find all pseudo elements below, create elements mocking pseudo element styles
  // so we can process them as normal elements, and hide the original pseudo elements so they don't interfere
  // with layout.
  function addPseudoElements(el) {
    // These are done in discrete steps to prevent a relayout loop caused by addClass() invalidating
    // layouts & getPseudoElement calling getComputedStyle.
    var jobs = [], classes = [];
    getPseudoElementClasses();
    findPseudoElements(el);
    runJobs();

    function getPseudoElementClasses(){
      var findPsuedoEls = /:before|:after/;
      var sheets = document.styleSheets;
      for (var i = 0, j = sheets.length; i < j; i++) {
        try {
          var rules = sheets[i].cssRules;
          for (var k = 0, l = rules.length; k < l; k++) {
            if(findPsuedoEls.test(rules[k].selectorText)) {
              classes.push(rules[k].selectorText);
            }
          }
        }
        catch(e) { // will throw security exception for style sheets loaded from external domains
        }
      }

      // Trim off the :after and :before (or ::after and ::before)
      for (i = 0, j = classes.length; i < j; i++) {
        classes[i] = classes[i].match(/(^[^:]*)/)[1].replace(/(\s+[>]\s+$)|([,]\s+$)/,'');
      }
    }

    // Using the list of elements we know how pseudo el styles, create fake pseudo elements.
    function findPseudoElements(el) {
      var els = document.querySelectorAll(classes.join(','));
      for(var i = 0, j = els.length; i < j; i++) {
        createPseudoElements(els[i]);
      }
    }

    // Create pseudo elements & add them to a job queue.
    function createPseudoElements(el) {
      var before = getPseudoElement(el, ':before'),
      after = getPseudoElement(el, ':after');

      if(before) {
        jobs.push({type: 'before', pseudo: before, el: el});
      }

      if (after) {
        jobs.push({type: 'after', pseudo: after, el: el});
      }
    }

    // Adds a class to the pseudo's parent to prevent the original before/after from messing
    // with layouts.
    // Execute the inserts & addClass() calls in a batch to prevent relayouts.
    function runJobs() {
      // Add Class
      jobs.forEach(function(job){
        addClass(job.el, pseudoHide + "-parent");
      });

      // Insert el
      jobs.forEach(function(job){
        if(job.type === 'before'){
          job.el.insertBefore(job.pseudo, job.el.firstChild);
        } else {
          job.el.appendChild(job.pseudo);
        }
      });
    }
  }



  // Delete our fake pseudo elements from the DOM. This will remove those actual elements
  // and the classes on their parents that hide the actual pseudo elements.
  // Note that NodeLists are 'live' collections so you can't use a for loop here. They are
  // actually deleted from the NodeList after each iteration.
  function removePseudoElements(){
    // delete pseudo elements
    body.removeChild(hidePseudoElementsStyles);
    var pseudos = document.getElementsByClassName(pseudoHide + "-element");
    while (pseudos.length) {
      pseudos[0].parentNode.removeChild(pseudos[0]);
    }

    // Remove pseudo hiding classes
    var parents = document.getElementsByClassName(pseudoHide + "-parent");
    while(parents.length) {
      removeClass(parents[0], pseudoHide + "-parent");
    }
  }

  function addClass (el, className) {
    if (el.classList) {
      el.classList.add(className);
    } else {
      el.className = el.className + " " + className;
    }
  }

  function removeClass (el, className) {
    if (el.classList) {
      el.classList.remove(className);
    } else {
      el.className = el.className.replace(className, "").trim();
    }
  }

  function hasClass (el, className) {
    return el.className.indexOf(className) > -1;
  }

  // Note that this doesn't work in < IE8, but we don't support that anyhow
  function nodeListToArray (nodeList) {
    return Array.prototype.slice.call(nodeList);
  }

  function documentWidth () {
    return Math.max(
      Math.max(doc.body.scrollWidth, doc.documentElement.scrollWidth),
      Math.max(doc.body.offsetWidth, doc.documentElement.offsetWidth),
      Math.max(doc.body.clientWidth, doc.documentElement.clientWidth)
      );
  }

  function documentHeight () {
    return Math.max(
      Math.max(doc.body.scrollHeight, doc.documentElement.scrollHeight),
      Math.max(doc.body.offsetHeight, doc.documentElement.offsetHeight),
      Math.max(doc.body.clientHeight, doc.documentElement.clientHeight)
      );
  }

  function getCSSInt(element, attribute) {
    var val = parseInt(getCSS(element, attribute), 10);
    return (isNaN(val)) ? 0 : val; // borders in old IE are throwing 'medium' for demo.html
  }

  function renderRect (ctx, x, y, w, h, bgcolor) {
    if (bgcolor !== "transparent"){
      ctx.setVariable("fillStyle", bgcolor);
      ctx.fillRect(x, y, w, h);
      numDraws+=1;
    }
  }

  function capitalize(m, p1, p2) {
    if (m.length > 0) {
      return p1 + p2.toUpperCase();
    }
  }

  function textTransform (text, transform) {
    switch(transform){
      case "lowercase":
        return text.toLowerCase();
      case "capitalize":
        return text.replace( /(^|\s|:|-|\(|\))([a-z])/g, capitalize);
      case "uppercase":
        return text.toUpperCase();
      default:
        return text;
    }
  }

  function noLetterSpacing(letter_spacing) {
    return (/^(normal|none|0px)$/.test(letter_spacing));
  }

  function drawText(currentText, x, y, ctx){
    if (currentText !== null && Util.trimText(currentText).length > 0) {
      ctx.fillText(currentText, x, y);
      numDraws+=1;
    }
  }

  function setTextVariables(ctx, el, text_decoration, color) {
    var align = false,
    bold = getCSS(el, "fontWeight"),
    family = getCSS(el, "fontFamily"),
    size = getCSS(el, "fontSize"),
    shadows = Util.parseTextShadows(getCSS(el, "textShadow"));

    switch(parseInt(bold, 10)){
      case 401:
        bold = "bold";
        break;
      case 400:
        bold = "normal";
        break;
    }

    ctx.setVariable("fillStyle", color);
    ctx.setVariable("font", [getCSS(el, "fontStyle"), getCSS(el, "fontVariant"), bold, size, family].join(" "));
    ctx.setVariable("textAlign", (align) ? "right" : "left");

    if (shadows.length) {
      // TODO: support multiple text shadows
      // apply the first text shadow
      ctx.setVariable("shadowColor", shadows[0].color);
      ctx.setVariable("shadowOffsetX", shadows[0].offsetX);
      ctx.setVariable("shadowOffsetY", shadows[0].offsetY);
      ctx.setVariable("shadowBlur", shadows[0].blur);
    }

    if (text_decoration !== "none"){
      return Util.Font(family, size, doc);
    }
  }

  function renderTextDecoration(ctx, text_decoration, bounds, metrics, color) {
    switch(text_decoration) {
      case "underline":
        // Draws a line at the baseline of the font
        // TODO As some browsers display the line as more than 1px if the font-size is big, need to take that into account both in position and size
        renderRect(ctx, bounds.left, Math.round(bounds.top + metrics.baseline + metrics.lineWidth), bounds.width, 1, color);
        break;
      case "overline":
        renderRect(ctx, bounds.left, Math.round(bounds.top), bounds.width, 1, color);
        break;
      case "line-through":
        // TODO try and find exact position for line-through
        renderRect(ctx, bounds.left, Math.ceil(bounds.top + metrics.middle + metrics.lineWidth), bounds.width, 1, color);
        break;
    }
  }

  function getTextBounds(state, text, textDecoration, isLast, transform) {
    var bounds;
    if (support.rangeBounds && !transform) {
      if (textDecoration !== "none" || Util.trimText(text).length !== 0) {
        bounds = textRangeBounds(text, state.node, state.textOffset);
      }
      state.textOffset += text.length;
    } else if (state.node && typeof state.node.nodeValue === "string" ){
      var newTextNode = (isLast) ? state.node.splitText(text.length) : null;
      bounds = textWrapperBounds(state.node, transform);
      state.node = newTextNode;
    }
    return bounds;
  }

  function textRangeBounds(text, textNode, textOffset) {
    var range = doc.createRange();
    range.setStart(textNode, textOffset);
    range.setEnd(textNode, textOffset + text.length);
    return range.getBoundingClientRect();
  }

  function textWrapperBounds(oldTextNode, transform) {
    var parent = oldTextNode.parentNode,
    wrapElement = doc.createElement('wrapper'),
    backupText = oldTextNode.cloneNode(true);

    wrapElement.appendChild(oldTextNode.cloneNode(true));
    parent.replaceChild(wrapElement, oldTextNode);

    var bounds = transform ? Util.OffsetBounds(wrapElement) : Util.Bounds(wrapElement);
    parent.replaceChild(backupText, wrapElement);
    return bounds;
  }

  function renderText(el, textNode, stack) {
    var ctx = stack.ctx,
    color = getCSS(el, "color"),
    textDecoration = getCSS(el, "textDecoration"),
    textAlign = getCSS(el, "textAlign"),
    metrics,
    textList,
    state = {
      node: textNode,
      textOffset: 0
    };

    if (Util.trimText(textNode.nodeValue).length > 0) {
      textNode.nodeValue = textTransform(textNode.nodeValue, getCSS(el, "textTransform"));
      textAlign = textAlign.replace(["-webkit-auto"],["auto"]);

      textList = (!options.letterRendering && /^(left|right|justify|auto)$/.test(textAlign) && noLetterSpacing(getCSS(el, "letterSpacing"))) ?
      textNode.nodeValue.split(/(\b| )/)
      : textNode.nodeValue.split("");

      metrics = setTextVariables(ctx, el, textDecoration, color);

      if (options.chinese) {
        textList.forEach(function(word, index) {
          if (/.*[\u4E00-\u9FA5].*$/.test(word)) {
            word = word.split("");
            word.unshift(index, 1);
            textList.splice.apply(textList, word);
          }
        });
      }

      textList.forEach(function(text, index) {
        var bounds = getTextBounds(state, text, textDecoration, (index < textList.length - 1), stack.transform.matrix);
        if (bounds) {
          drawText(text, bounds.left, bounds.bottom, ctx);
          renderTextDecoration(ctx, textDecoration, bounds, metrics, color);
        }
      });
    }
  }

  function listPosition (element, val) {
    var boundElement = doc.createElement( "boundelement" ),
    originalType,
    bounds;

    boundElement.style.display = "inline";

    originalType = element.style.listStyleType;
    element.style.listStyleType = "none";

    boundElement.appendChild(doc.createTextNode(val));

    element.insertBefore(boundElement, element.firstChild);

    bounds = Util.Bounds(boundElement);
    element.removeChild(boundElement);
    element.style.listStyleType = originalType;
    return bounds;
  }

  function elementIndex(el) {
    var i = -1,
    count = 1,
    childs = el.parentNode.childNodes;

    if (el.parentNode) {
      while(childs[++i] !== el) {
        if (childs[i].nodeType === 1) {
          count++;
        }
      }
      return count;
    } else {
      return -1;
    }
  }

  function listItemText(element, type) {
    var currentIndex = elementIndex(element), text;
    switch(type){
      case "decimal":
        text = currentIndex;
        break;
      case "decimal-leading-zero":
        text = (currentIndex.toString().length === 1) ? currentIndex = "0" + currentIndex.toString() : currentIndex.toString();
        break;
      case "upper-roman":
        text = _html2canvas.Generate.ListRoman( currentIndex );
        break;
      case "lower-roman":
        text = _html2canvas.Generate.ListRoman( currentIndex ).toLowerCase();
        break;
      case "lower-alpha":
        text = _html2canvas.Generate.ListAlpha( currentIndex ).toLowerCase();
        break;
      case "upper-alpha":
        text = _html2canvas.Generate.ListAlpha( currentIndex );
        break;
    }

    return text + ". ";
  }

  function renderListItem(element, stack, elBounds) {
    var x,
    text,
    ctx = stack.ctx,
    type = getCSS(element, "listStyleType"),
    listBounds;

    if (/^(decimal|decimal-leading-zero|upper-alpha|upper-latin|upper-roman|lower-alpha|lower-greek|lower-latin|lower-roman)$/i.test(type)) {
      text = listItemText(element, type);
      listBounds = listPosition(element, text);
      setTextVariables(ctx, element, "none", getCSS(element, "color"));

      if (getCSS(element, "listStylePosition") === "inside") {
        ctx.setVariable("textAlign", "left");
        x = elBounds.left;
      } else {
        return;
      }

      drawText(text, x, listBounds.bottom, ctx);
    }
  }

  function loadImage (src){
    var img = images[src];
    return (img && img.succeeded === true) ? img.img : false;
  }

  function clipBounds(src, dst){
    var x = Math.max(src.left, dst.left),
    y = Math.max(src.top, dst.top),
    x2 = Math.min((src.left + src.width), (dst.left + dst.width)),
    y2 = Math.min((src.top + src.height), (dst.top + dst.height));

    return {
      left:x,
      top:y,
      width:x2-x,
      height:y2-y
    };
  }

  function setZ(element, stack, parentStack){
    var newContext,
    isPositioned = stack.cssPosition !== 'static',
    zIndex = isPositioned ? getCSS(element, 'zIndex') : 'auto',
    opacity = getCSS(element, 'opacity'),
    isFloated = getCSS(element, 'cssFloat') !== 'none';

    // https://developer.mozilla.org/en-US/docs/Web/Guide/CSS/Understanding_z_index/The_stacking_context
    // When a new stacking context should be created:
    // the root element (HTML),
    // positioned (absolutely or relatively) with a z-index value other than "auto",
    // elements with an opacity value less than 1. (See the specification for opacity),
    // on mobile WebKit and Chrome 22+, position: fixed always creates a new stacking context, even when z-index is "auto" (See this post)

    stack.zIndex = newContext = h2czContext(zIndex);
    newContext.isPositioned = isPositioned;
    newContext.isFloated = isFloated;
    newContext.opacity = opacity;
    newContext.ownStacking = (zIndex !== 'auto' || opacity < 1);
    newContext.depth = parentStack ? (parentStack.zIndex.depth + 1) : 0;

    if (parentStack) {
      parentStack.zIndex.children.push(stack);
    }
  }

  function h2czContext(zindex) {
    return {
      depth: 0,
      zindex: zindex,
      children: []
    };
  }

  function renderImage(ctx, element, image, bounds, borders) {

    var paddingLeft = getCSSInt(element, 'paddingLeft'),
    paddingTop = getCSSInt(element, 'paddingTop'),
    paddingRight = getCSSInt(element, 'paddingRight'),
    paddingBottom = getCSSInt(element, 'paddingBottom');

    drawImage(
      ctx,
      image,
      0, //sx
      0, //sy
      image.width, //sw
      image.height, //sh
      bounds.left + paddingLeft + borders[3].width, //dx
      bounds.top + paddingTop + borders[0].width, // dy
      bounds.width - (borders[1].width + borders[3].width + paddingLeft + paddingRight), //dw
      bounds.height - (borders[0].width + borders[2].width + paddingTop + paddingBottom) //dh
      );
  }

  function getBorderData(element) {
    return ["Top", "Right", "Bottom", "Left"].map(function(side) {
      return {
        width: getCSSInt(element, 'border' + side + 'Width'),
        color: getCSS(element, 'border' + side + 'Color')
      };
    });
  }

  function getBorderRadiusData(element) {
    return ["TopLeft", "TopRight", "BottomRight", "BottomLeft"].map(function(side) {
      return getCSS(element, 'border' + side + 'Radius');
    });
  }

  function getCurvePoints(x, y, r1, r2) {
    var kappa = 4 * ((Math.sqrt(2) - 1) / 3);
    var ox = (r1) * kappa, // control point offset horizontal
    oy = (r2) * kappa, // control point offset vertical
    xm = x + r1, // x-middle
    ym = y + r2; // y-middle
    return {
      topLeft: bezierCurve({
        x:x,
        y:ym
      }, {
        x:x,
        y:ym - oy
      }, {
        x:xm - ox,
        y:y
      }, {
        x:xm,
        y:y
      }),
      topRight: bezierCurve({
        x:x,
        y:y
      }, {
        x:x + ox,
        y:y
      }, {
        x:xm,
        y:ym - oy
      }, {
        x:xm,
        y:ym
      }),
      bottomRight: bezierCurve({
        x:xm,
        y:y
      }, {
        x:xm,
        y:y + oy
      }, {
        x:x + ox,
        y:ym
      }, {
        x:x,
        y:ym
      }),
      bottomLeft: bezierCurve({
        x:xm,
        y:ym
      }, {
        x:xm - ox,
        y:ym
      }, {
        x:x,
        y:y + oy
      }, {
        x:x,
        y:y
      })
    };
  }

  function bezierCurve(start, startControl, endControl, end) {

    var lerp = function (a, b, t) {
      return {
        x:a.x + (b.x - a.x) * t,
        y:a.y + (b.y - a.y) * t
      };
    };

    return {
      start: start,
      startControl: startControl,
      endControl: endControl,
      end: end,
      subdivide: function(t) {
        var ab = lerp(start, startControl, t),
        bc = lerp(startControl, endControl, t),
        cd = lerp(endControl, end, t),
        abbc = lerp(ab, bc, t),
        bccd = lerp(bc, cd, t),
        dest = lerp(abbc, bccd, t);
        return [bezierCurve(start, ab, abbc, dest), bezierCurve(dest, bccd, cd, end)];
      },
      curveTo: function(borderArgs) {
        borderArgs.push(["bezierCurve", startControl.x, startControl.y, endControl.x, endControl.y, end.x, end.y]);
      },
      curveToReversed: function(borderArgs) {
        borderArgs.push(["bezierCurve", endControl.x, endControl.y, startControl.x, startControl.y, start.x, start.y]);
      }
    };
  }

  function parseCorner(borderArgs, radius1, radius2, corner1, corner2, x, y) {
    if (radius1[0] > 0 || radius1[1] > 0) {
      borderArgs.push(["line", corner1[0].start.x, corner1[0].start.y]);
      corner1[0].curveTo(borderArgs);
      corner1[1].curveTo(borderArgs);
    } else {
      borderArgs.push(["line", x, y]);
    }

    if (radius2[0] > 0 || radius2[1] > 0) {
      borderArgs.push(["line", corner2[0].start.x, corner2[0].start.y]);
    }
  }

  function drawSide(borderData, radius1, radius2, outer1, inner1, outer2, inner2) {
    var borderArgs = [];

    if (radius1[0] > 0 || radius1[1] > 0) {
      borderArgs.push(["line", outer1[1].start.x, outer1[1].start.y]);
      outer1[1].curveTo(borderArgs);
    } else {
      borderArgs.push([ "line", borderData.c1[0], borderData.c1[1]]);
    }

    if (radius2[0] > 0 || radius2[1] > 0) {
      borderArgs.push(["line", outer2[0].start.x, outer2[0].start.y]);
      outer2[0].curveTo(borderArgs);
      borderArgs.push(["line", inner2[0].end.x, inner2[0].end.y]);
      inner2[0].curveToReversed(borderArgs);
    } else {
      borderArgs.push([ "line", borderData.c2[0], borderData.c2[1]]);
      borderArgs.push([ "line", borderData.c3[0], borderData.c3[1]]);
    }

    if (radius1[0] > 0 || radius1[1] > 0) {
      borderArgs.push(["line", inner1[1].end.x, inner1[1].end.y]);
      inner1[1].curveToReversed(borderArgs);
    } else {
      borderArgs.push([ "line", borderData.c4[0], borderData.c4[1]]);
    }

    return borderArgs;
  }

  function calculateCurvePoints(bounds, borderRadius, borders) {

    var x = bounds.left,
    y = bounds.top,
    width = bounds.width,
    height = bounds.height,

    tlh = borderRadius[0][0],
    tlv = borderRadius[0][1],
    trh = borderRadius[1][0],
    trv = borderRadius[1][1],
    brh = borderRadius[2][0],
    brv = borderRadius[2][1],
    blh = borderRadius[3][0],
    blv = borderRadius[3][1],

    topWidth = width - trh,
    rightHeight = height - brv,
    bottomWidth = width - brh,
    leftHeight = height - blv;

    return {
      topLeftOuter: getCurvePoints(
        x,
        y,
        tlh,
        tlv
        ).topLeft.subdivide(0.5),

      topLeftInner: getCurvePoints(
        x + borders[3].width,
        y + borders[0].width,
        Math.max(0, tlh - borders[3].width),
        Math.max(0, tlv - borders[0].width)
        ).topLeft.subdivide(0.5),

      topRightOuter: getCurvePoints(
        x + topWidth,
        y,
        trh,
        trv
        ).topRight.subdivide(0.5),

      topRightInner: getCurvePoints(
        x + Math.min(topWidth, width + borders[3].width),
        y + borders[0].width,
        (topWidth > width + borders[3].width) ? 0 :trh - borders[3].width,
        trv - borders[0].width
        ).topRight.subdivide(0.5),

      bottomRightOuter: getCurvePoints(
        x + bottomWidth,
        y + rightHeight,
        brh,
        brv
        ).bottomRight.subdivide(0.5),

      bottomRightInner: getCurvePoints(
        x + Math.min(bottomWidth, width + borders[3].width),
        y + Math.min(rightHeight, height + borders[0].width),
        Math.max(0, brh - borders[1].width),
        Math.max(0, brv - borders[2].width)
        ).bottomRight.subdivide(0.5),

      bottomLeftOuter: getCurvePoints(
        x,
        y + leftHeight,
        blh,
        blv
        ).bottomLeft.subdivide(0.5),

      bottomLeftInner: getCurvePoints(
        x + borders[3].width,
        y + leftHeight,
        Math.max(0, blh - borders[3].width),
        Math.max(0, blv - borders[2].width)
        ).bottomLeft.subdivide(0.5)
    };
  }

  function getBorderClip(element, borderPoints, borders, radius, bounds) {
    var backgroundClip = getCSS(element, 'backgroundClip'),
    borderArgs = [];

    switch(backgroundClip) {
      case "content-box":
      case "padding-box":
        parseCorner(borderArgs, radius[0], radius[1], borderPoints.topLeftInner, borderPoints.topRightInner, bounds.left + borders[3].width, bounds.top + borders[0].width);
        parseCorner(borderArgs, radius[1], radius[2], borderPoints.topRightInner, borderPoints.bottomRightInner, bounds.left + bounds.width - borders[1].width, bounds.top + borders[0].width);
        parseCorner(borderArgs, radius[2], radius[3], borderPoints.bottomRightInner, borderPoints.bottomLeftInner, bounds.left + bounds.width - borders[1].width, bounds.top + bounds.height - borders[2].width);
        parseCorner(borderArgs, radius[3], radius[0], borderPoints.bottomLeftInner, borderPoints.topLeftInner, bounds.left + borders[3].width, bounds.top + bounds.height - borders[2].width);
        break;

      default:
        parseCorner(borderArgs, radius[0], radius[1], borderPoints.topLeftOuter, borderPoints.topRightOuter, bounds.left, bounds.top);
        parseCorner(borderArgs, radius[1], radius[2], borderPoints.topRightOuter, borderPoints.bottomRightOuter, bounds.left + bounds.width, bounds.top);
        parseCorner(borderArgs, radius[2], radius[3], borderPoints.bottomRightOuter, borderPoints.bottomLeftOuter, bounds.left + bounds.width, bounds.top + bounds.height);
        parseCorner(borderArgs, radius[3], radius[0], borderPoints.bottomLeftOuter, borderPoints.topLeftOuter, bounds.left, bounds.top + bounds.height);
        break;
    }

    return borderArgs;
  }

  function parseBorders(element, bounds, borders){
    var x = bounds.left,
    y = bounds.top,
    width = bounds.width,
    height = bounds.height,
    borderSide,
    bx,
    by,
    bw,
    bh,
    borderArgs,
    // http://www.w3.org/TR/css3-background/#the-border-radius
    borderRadius = getBorderRadiusData(element),
    borderPoints = calculateCurvePoints(bounds, borderRadius, borders),
    borderData = {
      clip: getBorderClip(element, borderPoints, borders, borderRadius, bounds),
      borders: []
    };

    for (borderSide = 0; borderSide < 4; borderSide++) {

      if (borders[borderSide].width > 0) {
        bx = x;
        by = y;
        bw = width;
        bh = height - (borders[2].width);

        switch(borderSide) {
          case 0:
            // top border
            bh = borders[0].width;

            borderArgs = drawSide({
              c1: [bx, by],
              c2: [bx + bw, by],
              c3: [bx + bw - borders[1].width, by + bh],
              c4: [bx + borders[3].width, by + bh]
            }, borderRadius[0], borderRadius[1],
            borderPoints.topLeftOuter, borderPoints.topLeftInner, borderPoints.topRightOuter, borderPoints.topRightInner);
            break;
          case 1:
            // right border
            bx = x + width - (borders[1].width);
            bw = borders[1].width;

            borderArgs = drawSide({
              c1: [bx + bw, by],
              c2: [bx + bw, by + bh + borders[2].width],
              c3: [bx, by + bh],
              c4: [bx, by + borders[0].width]
            }, borderRadius[1], borderRadius[2],
            borderPoints.topRightOuter, borderPoints.topRightInner, borderPoints.bottomRightOuter, borderPoints.bottomRightInner);
            break;
          case 2:
            // bottom border
            by = (by + height) - (borders[2].width);
            bh = borders[2].width;

            borderArgs = drawSide({
              c1: [bx + bw, by + bh],
              c2: [bx, by + bh],
              c3: [bx + borders[3].width, by],
              c4: [bx + bw - borders[3].width, by]
            }, borderRadius[2], borderRadius[3],
            borderPoints.bottomRightOuter, borderPoints.bottomRightInner, borderPoints.bottomLeftOuter, borderPoints.bottomLeftInner);
            break;
          case 3:
            // left border
            bw = borders[3].width;

            borderArgs = drawSide({
              c1: [bx, by + bh + borders[2].width],
              c2: [bx, by],
              c3: [bx + bw, by + borders[0].width],
              c4: [bx + bw, by + bh]
            }, borderRadius[3], borderRadius[0],
            borderPoints.bottomLeftOuter, borderPoints.bottomLeftInner, borderPoints.topLeftOuter, borderPoints.topLeftInner);
            break;
        }

        borderData.borders.push({
          args: borderArgs,
          color: borders[borderSide].color
        });

      }
    }

    return borderData;
  }

  function createShape(ctx, args) {
    var shape = ctx.drawShape();
    args.forEach(function(border, index) {
      shape[(index === 0) ? "moveTo" : border[0] + "To" ].apply(null, border.slice(1));
    });
    return shape;
  }

  function renderBorders(ctx, borderArgs, color) {
    if (color !== "transparent") {
      ctx.setVariable( "fillStyle", color);
      createShape(ctx, borderArgs);
      ctx.fill();
      numDraws+=1;
    }
  }

  function renderFormValue (el, bounds, stack){

    var valueWrap = doc.createElement('valuewrap'),
    cssPropertyArray = ['lineHeight','textAlign','fontFamily','color','fontSize','paddingLeft','paddingTop','width','height','border','borderLeftWidth','borderTopWidth'],
    textValue,
    textNode;

    cssPropertyArray.forEach(function(property) {
      try {
        valueWrap.style[property] = getCSS(el, property);
      } catch(e) {
        // Older IE has issues with "border"
        Util.log("html2canvas: Parse: Exception caught in renderFormValue: " + e.message);
      }
    });

    valueWrap.style.borderColor = "black";
    valueWrap.style.borderStyle = "solid";
    valueWrap.style.display = "block";
    valueWrap.style.position = "absolute";

    if (/^(submit|reset|button|text|password)$/.test(el.type) || el.nodeName === "SELECT"){
      valueWrap.style.lineHeight = getCSS(el, "height");
    }

    valueWrap.style.top = bounds.top + "px";
    valueWrap.style.left = bounds.left + "px";

    textValue = (el.nodeName === "SELECT") ? (el.options[el.selectedIndex] || 0).text : el.value;
    if(!textValue) {
      textValue = el.placeholder;
    }

    textNode = doc.createTextNode(textValue);

    valueWrap.appendChild(textNode);
    body.appendChild(valueWrap);

    renderText(el, textNode, stack);
    body.removeChild(valueWrap);
  }

  function drawImage (ctx) {
    ctx.drawImage.apply(ctx, Array.prototype.slice.call(arguments, 1));
    numDraws+=1;
  }

  function getPseudoElement(el, which) {
    var elStyle = window.getComputedStyle(el, which);
    var parentStyle = window.getComputedStyle(el);
    // If no content attribute is present, the pseudo element is hidden,
    // or the parent has a content property equal to the content on the pseudo element,
    // move along.
    if(!elStyle || !elStyle.content || elStyle.content === "none" || elStyle.content === "-moz-alt-content" ||
       elStyle.display === "none" || parentStyle.content === elStyle.content) {
      return;
    }
    var content = elStyle.content + '';

    // Strip inner quotes
    if(content[0] === "'" || content[0] === "\"") {
      content = content.replace(/(^['"])|(['"]$)/g, '');
    }

    var isImage = content.substr( 0, 3 ) === 'url',
    elps = document.createElement( isImage ? 'img' : 'span' );

    elps.className = pseudoHide + "-element ";

    Object.keys(elStyle).filter(indexedProperty).forEach(function(prop) {
      // Prevent assigning of read only CSS Rules, ex. length, parentRule
      try {
        elps.style[prop] = elStyle[prop];
      } catch (e) {
        Util.log(['Tried to assign readonly property ', prop, 'Error:', e]);
      }
    });

    if(isImage) {
      elps.src = Util.parseBackgroundImage(content)[0].args[0];
    } else {
      elps.innerHTML = content;
    }
    return elps;
  }

  function indexedProperty(property) {
    return (isNaN(window.parseInt(property, 10)));
  }

  function renderBackgroundRepeat(ctx, image, backgroundPosition, bounds) {
    var offsetX = Math.round(bounds.left + backgroundPosition.left),
    offsetY = Math.round(bounds.top + backgroundPosition.top);

    ctx.createPattern(image);
    ctx.translate(offsetX, offsetY);
    ctx.fill();
    ctx.translate(-offsetX, -offsetY);
  }

  function backgroundRepeatShape(ctx, image, backgroundPosition, bounds, left, top, width, height) {
    var args = [];
    args.push(["line", Math.round(left), Math.round(top)]);
    args.push(["line", Math.round(left + width), Math.round(top)]);
    args.push(["line", Math.round(left + width), Math.round(height + top)]);
    args.push(["line", Math.round(left), Math.round(height + top)]);
    createShape(ctx, args);
    ctx.save();
    ctx.clip();
    renderBackgroundRepeat(ctx, image, backgroundPosition, bounds);
    ctx.restore();
  }

  function renderBackgroundColor(ctx, backgroundBounds, bgcolor) {
    renderRect(
      ctx,
      backgroundBounds.left,
      backgroundBounds.top,
      backgroundBounds.width,
      backgroundBounds.height,
      bgcolor
      );
  }

  function renderBackgroundRepeating(el, bounds, ctx, image, imageIndex) {
    var backgroundSize = Util.BackgroundSize(el, bounds, image, imageIndex),
    backgroundPosition = Util.BackgroundPosition(el, bounds, image, imageIndex, backgroundSize),
    backgroundRepeat = Util.BackgroundRepeat(el, imageIndex);

    image = resizeImage(image, backgroundSize);

    switch (backgroundRepeat) {
      case "repeat-x":
      case "repeat no-repeat":
        backgroundRepeatShape(ctx, image, backgroundPosition, bounds,
          bounds.left, bounds.top + backgroundPosition.top, 99999, image.height);
        break;
      case "repeat-y":
      case "no-repeat repeat":
        backgroundRepeatShape(ctx, image, backgroundPosition, bounds,
          bounds.left + backgroundPosition.left, bounds.top, image.width, 99999);
        break;
      case "no-repeat":
        backgroundRepeatShape(ctx, image, backgroundPosition, bounds,
          bounds.left + backgroundPosition.left, bounds.top + backgroundPosition.top, image.width, image.height);
        break;
      default:
        renderBackgroundRepeat(ctx, image, backgroundPosition, {
          top: bounds.top,
          left: bounds.left,
          width: image.width,
          height: image.height
        });
        break;
    }
  }

  function renderBackgroundImage(element, bounds, ctx) {
    var backgroundImage = getCSS(element, "backgroundImage"),
    backgroundImages = Util.parseBackgroundImage(backgroundImage),
    image,
    imageIndex = backgroundImages.length;

    while(imageIndex--) {
      backgroundImage = backgroundImages[imageIndex];

      if (!backgroundImage.args || backgroundImage.args.length === 0) {
        continue;
      }

      var key = backgroundImage.method === 'url' ?
      backgroundImage.args[0] :
      backgroundImage.value;

      image = loadImage(key);

      // TODO add support for background-origin
      if (image) {
        renderBackgroundRepeating(element, bounds, ctx, image, imageIndex);
      } else {
        Util.log("html2canvas: Error loading background:", backgroundImage);
      }
    }
  }

  function resizeImage(image, bounds) {
    if(image.width === bounds.width && image.height === bounds.height) {
      return image;
    }

    var ctx, canvas = doc.createElement('canvas');
    canvas.width = bounds.width;
    canvas.height = bounds.height;
    ctx = canvas.getContext("2d");
    drawImage(ctx, image, 0, 0, image.width, image.height, 0, 0, bounds.width, bounds.height );
    return canvas;
  }

  function setOpacity(ctx, element, parentStack) {
    return ctx.setVariable("globalAlpha", getCSS(element, "opacity") * ((parentStack) ? parentStack.opacity : 1));
  }

  function removePx(str) {
    return str.replace("px", "");
  }

  function getTransform(element, parentStack) {
    var transformRegExp = /(matrix)\((.+)\)/;
    var transform = getCSS(element, "transform") || getCSS(element, "-webkit-transform") || getCSS(element, "-moz-transform") || getCSS(element, "-ms-transform") || getCSS(element, "-o-transform");
    var transformOrigin = getCSS(element, "transform-origin") || getCSS(element, "-webkit-transform-origin") || getCSS(element, "-moz-transform-origin") || getCSS(element, "-ms-transform-origin") || getCSS(element, "-o-transform-origin") || "0px 0px";

    transformOrigin = transformOrigin.split(" ").map(removePx).map(Util.asFloat);

    var matrix;
    if (transform && transform !== "none") {
      var match = transform.match(transformRegExp);
      if (match) {
        switch(match[1]) {
          case "matrix":
            matrix = match[2].split(",").map(Util.trimText).map(Util.asFloat);
            break;
        }
      }
    }

    return {
      origin: transformOrigin,
      matrix: matrix
    };
  }

  function createStack(element, parentStack, bounds, transform) {
    var ctx = h2cRenderContext((!parentStack) ? documentWidth() : bounds.width , (!parentStack) ? documentHeight() : bounds.height),
    stack = {
      ctx: ctx,
      opacity: setOpacity(ctx, element, parentStack),
      cssPosition: getCSS(element, "position"),
      borders: getBorderData(element),
      transform: transform,
      clip: (parentStack && parentStack.clip) ? Util.Extend( {}, parentStack.clip ) : null
    };

    setZ(element, stack, parentStack);

    // TODO correct overflow for absolute content residing under a static position
    if (options.useOverflow === true && /(hidden|scroll|auto)/.test(getCSS(element, "overflow")) === true && /(BODY)/i.test(element.nodeName) === false){
      stack.clip = (stack.clip) ? clipBounds(stack.clip, bounds) : bounds;
    }

    return stack;
  }

  function getBackgroundBounds(borders, bounds, clip) {
    var backgroundBounds = {
      left: bounds.left + borders[3].width,
      top: bounds.top + borders[0].width,
      width: bounds.width - (borders[1].width + borders[3].width),
      height: bounds.height - (borders[0].width + borders[2].width)
    };

    if (clip) {
      backgroundBounds = clipBounds(backgroundBounds, clip);
    }

    return backgroundBounds;
  }

  function getBounds(element, transform) {
    var bounds = (transform.matrix) ? Util.OffsetBounds(element) : Util.Bounds(element);
    transform.origin[0] += bounds.left;
    transform.origin[1] += bounds.top;
    return bounds;
  }

  function renderElement(element, parentStack, ignoreBackground) {
    var transform = getTransform(element, parentStack),
    bounds = getBounds(element, transform),
    image,
    stack = createStack(element, parentStack, bounds, transform),
    borders = stack.borders,
    ctx = stack.ctx,
    backgroundBounds = getBackgroundBounds(borders, bounds, stack.clip),
    borderData = parseBorders(element, bounds, borders),
    backgroundColor = (ignoreElementsRegExp.test(element.nodeName)) ? "#efefef" : getCSS(element, "backgroundColor");


    createShape(ctx, borderData.clip);

    ctx.save();
    ctx.clip();

    if (backgroundBounds.height > 0 && backgroundBounds.width > 0 && !ignoreBackground) {
      renderBackgroundColor(ctx, bounds, backgroundColor);
      renderBackgroundImage(element, backgroundBounds, ctx);
    } else if (ignoreBackground) {
      stack.backgroundColor =  backgroundColor;
    }

    ctx.restore();

    borderData.borders.forEach(function(border) {
      renderBorders(ctx, border.args, border.color);
    });

    switch(element.nodeName){
      case "IMG":
        if ((image = loadImage(element.getAttribute('src')))) {
          renderImage(ctx, element, image, bounds, borders);
        } else {
          Util.log("html2canvas: Error loading <img>:" + element.getAttribute('src'));
        }
        break;
      case "INPUT":
        // TODO add all relevant type's, i.e. HTML5 new stuff
        // todo add support for placeholder attribute for browsers which support it
        if (/^(text|url|email|submit|button|reset)$/.test(element.type) && (element.value || element.placeholder || "").length > 0){
          renderFormValue(element, bounds, stack);
        }
        break;
      case "TEXTAREA":
        if ((element.value || element.placeholder || "").length > 0){
          renderFormValue(element, bounds, stack);
        }
        break;
      case "SELECT":
        if ((element.options||element.placeholder || "").length > 0){
          renderFormValue(element, bounds, stack);
        }
        break;
      case "LI":
        renderListItem(element, stack, backgroundBounds);
        break;
      case "CANVAS":
        renderImage(ctx, element, element, bounds, borders);
        break;
    }

    return stack;
  }

  function isElementVisible(element) {
    return (getCSS(element, 'display') !== "none" && getCSS(element, 'visibility') !== "hidden" && !element.hasAttribute("data-html2canvas-ignore"));
  }

  function parseElement (element, stack, cb) {
    if (!cb) {
      cb = function(){};
    }
    if (isElementVisible(element)) {
      stack = renderElement(element, stack, false) || stack;
      if (!ignoreElementsRegExp.test(element.nodeName)) {
        return parseChildren(element, stack, cb);
      }
    }
    cb();
  }

  function parseChildren(element, stack, cb) {
    var children = Util.Children(element);
    // After all nodes have processed, finished() will call the cb.
    // We add one and kick it off so this will still work when children.length === 0.
    // Note that unless async is true, this will happen synchronously, just will callbacks.
    var jobs = children.length + 1;
    finished();

    if (options.async) {
      children.forEach(function(node) {
        // Don't block the page from rendering
        setTimeout(function(){ parseNode(node); }, 0);
      });
    } else {
      children.forEach(parseNode);
    }

    function parseNode(node) {
      if (node.nodeType === node.ELEMENT_NODE) {
        parseElement(node, stack, finished);
      } else if (node.nodeType === node.TEXT_NODE) {
        renderText(element, node, stack);
        finished();
      } else {
        finished();
      }
    }
    function finished(el) {
      if (--jobs <= 0){
        Util.log("finished rendering " + children.length + " children.");
        cb();
      }
    }
  }
};
_html2canvas.Preload = function( options ) {

  var images = {
    numLoaded: 0,   // also failed are counted here
    numFailed: 0,
    numTotal: 0,
    cleanupDone: false
  },
  pageOrigin,
  Util = _html2canvas.Util,
  methods,
  i,
  count = 0,
  element = options.elements[0] || document.body,
  doc = element.ownerDocument,
  domImages = element.getElementsByTagName('img'), // Fetch images of the present element only
  imgLen = domImages.length,
  link = doc.createElement("a"),
  supportCORS = (function( img ){
    return (img.crossOrigin !== undefined);
  })(new Image()),
  timeoutTimer;

  link.href = window.location.href;
  pageOrigin  = link.protocol + link.host;

  function isSameOrigin(url){
    link.href = url;
    link.href = link.href; // YES, BELIEVE IT OR NOT, that is required for IE9 - http://jsfiddle.net/niklasvh/2e48b/
    var origin = link.protocol + link.host;
    return (origin === pageOrigin);
  }

  function start(){
    Util.log("html2canvas: start: images: " + images.numLoaded + " / " + images.numTotal + " (failed: " + images.numFailed + ")");
    if (!images.firstRun && images.numLoaded >= images.numTotal){
      Util.log("Finished loading images: # " + images.numTotal + " (failed: " + images.numFailed + ")");

      if (typeof options.complete === "function"){
        options.complete(images);
      }

    }
  }

  // TODO modify proxy to serve images with CORS enabled, where available
  function proxyGetImage(url, img, imageObj){
    var callback_name,
    scriptUrl = options.proxy,
    script;

    link.href = url;
    url = link.href; // work around for pages with base href="" set - WARNING: this may change the url

    callback_name = 'html2canvas_' + (count++);
    imageObj.callbackname = callback_name;

    if (scriptUrl.indexOf("?") > -1) {
      scriptUrl += "&";
    } else {
      scriptUrl += "?";
    }
    scriptUrl += 'url=' + encodeURIComponent(url) + '&callback=' + callback_name;
    script = doc.createElement("script");

    window[callback_name] = function(a){
      if (a.substring(0,6) === "error:"){
        imageObj.succeeded = false;
        images.numLoaded++;
        images.numFailed++;
        start();
      } else {
        setImageLoadHandlers(img, imageObj);
        img.src = a;
      }
      window[callback_name] = undefined; // to work with IE<9  // NOTE: that the undefined callback property-name still exists on the window object (for IE<9)
      try {
        delete window[callback_name];  // for all browser that support this
      } catch(ex) {}
      script.parentNode.removeChild(script);
      script = null;
      delete imageObj.script;
      delete imageObj.callbackname;
    };

    script.setAttribute("type", "text/javascript");
    script.setAttribute("src", scriptUrl);
    imageObj.script = script;
    window.document.body.appendChild(script);

  }

  function loadPseudoElement(element, type) {
    var style = window.getComputedStyle(element, type),
    content = style.content;
    if (content.substr(0, 3) === 'url') {
      methods.loadImage(_html2canvas.Util.parseBackgroundImage(content)[0].args[0]);
    }
    loadBackgroundImages(style.backgroundImage, element);
  }

  function loadPseudoElementImages(element) {
    loadPseudoElement(element, ":before");
    loadPseudoElement(element, ":after");
  }

  function loadGradientImage(backgroundImage, bounds) {
    var img = _html2canvas.Generate.Gradient(backgroundImage, bounds);

    if (img !== undefined){
      images[backgroundImage] = {
        img: img,
        succeeded: true
      };
      images.numTotal++;
      images.numLoaded++;
      start();
    }
  }

  function invalidBackgrounds(background_image) {
    return (background_image && background_image.method && background_image.args && background_image.args.length > 0 );
  }

  function loadBackgroundImages(background_image, el) {
    var bounds;

    _html2canvas.Util.parseBackgroundImage(background_image).filter(invalidBackgrounds).forEach(function(background_image) {
      if (background_image.method === 'url') {
        methods.loadImage(background_image.args[0]);
      } else if(background_image.method.match(/\-?gradient$/)) {
        if(bounds === undefined) {
          bounds = _html2canvas.Util.Bounds(el);
        }
        loadGradientImage(background_image.value, bounds);
      }
    });
  }

  function getImages (el) {
    var elNodeType = false;

    // Firefox fails with permission denied on pages with iframes
    try {
      Util.Children(el).forEach(getImages);
    }
    catch( e ) {}

    try {
      elNodeType = el.nodeType;
    } catch (ex) {
      elNodeType = false;
      Util.log("html2canvas: failed to access some element's nodeType - Exception: " + ex.message);
    }

    if (elNodeType === 1 || elNodeType === undefined) {
      loadPseudoElementImages(el);
      try {
        loadBackgroundImages(Util.getCSS(el, 'backgroundImage'), el);
      } catch(e) {
        Util.log("html2canvas: failed to get background-image - Exception: " + e.message);
      }
      loadBackgroundImages(el);
    }
  }

  function setImageLoadHandlers(img, imageObj) {
    img.onload = function() {
      if ( imageObj.timer !== undefined ) {
        // CORS succeeded
        window.clearTimeout( imageObj.timer );
      }

      images.numLoaded++;
      imageObj.succeeded = true;
      img.onerror = img.onload = null;
      start();
    };
    img.onerror = function() {
      if (img.crossOrigin === "anonymous") {
        // CORS failed
        window.clearTimeout( imageObj.timer );

        // let's try with proxy instead
        if ( options.proxy ) {
          var src = img.src;
          img = new Image();
          imageObj.img = img;
          img.src = src;

          proxyGetImage( img.src, img, imageObj );
          return;
        }
      }

      images.numLoaded++;
      images.numFailed++;
      imageObj.succeeded = false;
      img.onerror = img.onload = null;
      start();
    };
  }

  methods = {
    loadImage: function( src ) {
      var img, imageObj;
      if ( src && images[src] === undefined ) {
        img = new Image();
        if ( src.match(/data:image\/.*;base64,/i) ) {
          img.src = src.replace(/url\(['"]{0,}|['"]{0,}\)$/ig, '');
          imageObj = images[src] = {
            img: img
          };
          images.numTotal++;
          setImageLoadHandlers(img, imageObj);
        } else if ( isSameOrigin( src ) || options.allowTaint ===  true ) {
          imageObj = images[src] = {
            img: img
          };
          images.numTotal++;
          setImageLoadHandlers(img, imageObj);
          img.src = src;
        } else if ( supportCORS && !options.allowTaint && options.useCORS ) {
          // attempt to load with CORS

          img.crossOrigin = "anonymous";
          imageObj = images[src] = {
            img: img
          };
          images.numTotal++;
          setImageLoadHandlers(img, imageObj);
          img.src = src;
        } else if ( options.proxy ) {
          imageObj = images[src] = {
            img: img
          };
          images.numTotal++;
          proxyGetImage( src, img, imageObj );
        }
      }

    },
    cleanupDOM: function(cause) {
      var img, src;
      if (!images.cleanupDone) {
        if (cause && typeof cause === "string") {
          Util.log("html2canvas: Cleanup because: " + cause);
        } else {
          Util.log("html2canvas: Cleanup after timeout: " + options.timeout + " ms.");
        }

        for (src in images) {
          if (images.hasOwnProperty(src)) {
            img = images[src];
            if (typeof img === "object" && img.callbackname && img.succeeded === undefined) {
              // cancel proxy image request
              window[img.callbackname] = undefined; // to work with IE<9  // NOTE: that the undefined callback property-name still exists on the window object (for IE<9)
              try {
                delete window[img.callbackname];  // for all browser that support this
              } catch(ex) {}
              if (img.script && img.script.parentNode) {
                img.script.setAttribute("src", "about:blank");  // try to cancel running request
                img.script.parentNode.removeChild(img.script);
              }
              images.numLoaded++;
              images.numFailed++;
              Util.log("html2canvas: Cleaned up failed img: '" + src + "' Steps: " + images.numLoaded + " / " + images.numTotal);
            }
          }
        }

        // cancel any pending requests
        if(window.stop !== undefined) {
          window.stop();
        } else if(document.execCommand !== undefined) {
          document.execCommand("Stop", false);
        }
        if (document.close !== undefined) {
          document.close();
        }
        images.cleanupDone = true;
        if (!(cause && typeof cause === "string")) {
          start();
        }
      }
    },

    renderingDone: function() {
      if (timeoutTimer) {
        window.clearTimeout(timeoutTimer);
      }
    }
  };

  if (options.timeout > 0) {
    timeoutTimer = window.setTimeout(methods.cleanupDOM, options.timeout);
  }

  Util.log('html2canvas: Preload starts: finding background-images');
  images.firstRun = true;

  getImages(element);

  Util.log('html2canvas: Preload: Finding images');
  // load <img> images
  for (i = 0; i < imgLen; i+=1){
    methods.loadImage( domImages[i].getAttribute( "src" ) );
  }

  images.firstRun = false;
  Util.log('html2canvas: Preload: Done.');
  if (images.numTotal === images.numLoaded) {
    start();
  }

  return methods;
};

_html2canvas.Renderer = function(parseQueue, options){
  function sortZindex(a, b) {
    if (a === 'children') {
      return -1;
    } else if (b === 'children') {
      return 1;
    } else {
      return a - b;
    }
  }

  // http://www.w3.org/TR/CSS21/zindex.html
  function createRenderQueue(parseQueue) {
    var queue = [],
    rootContext;

    rootContext = (function buildStackingContext(rootNode) {
      var rootContext = {};
      function insert(context, node, specialParent) {
        var zi = (node.zIndex.zindex === 'auto') ? 0 : Number(node.zIndex.zindex),
        contextForChildren = context, // the stacking context for children
        isPositioned = node.zIndex.isPositioned,
        isFloated = node.zIndex.isFloated,
        stub = {node: node},
        childrenDest = specialParent; // where children without z-index should be pushed into

        if (node.zIndex.ownStacking) {
          contextForChildren = stub.context = {
              children: [{node:node, children: []}]
          };
          childrenDest = undefined;
        } else if (isPositioned || isFloated) {
          childrenDest = stub.children = [];
        }

        if (zi === 0 && specialParent) {
          specialParent.push(stub);
        } else {
          if (!context[zi]) { context[zi] = []; }
          context[zi].push(stub);
        }

        node.zIndex.children.forEach(function(childNode) {
          insert(contextForChildren, childNode, childrenDest);
        });
      }
      insert(rootContext, rootNode);
      return rootContext;
    })(parseQueue);

    function sortZ(context) {
      Object.keys(context).sort(sortZindex).forEach(function(zi) {
        var nonPositioned = [],
        floated = [],
        positioned = [],
        list = [];

        // positioned after static
        context[zi].forEach(function(v) {
          if (v.node.zIndex.isPositioned || v.node.zIndex.opacity < 1) {
            // http://www.w3.org/TR/css3-color/#transparency
            // non-positioned element with opactiy < 1 should be stacked as if it were a positioned element with ‘z-index: 0’ and ‘opacity: 1’.
            positioned.push(v);
          } else if (v.node.zIndex.isFloated) {
            floated.push(v);
          } else {
            nonPositioned.push(v);
          }
        });

        (function walk(arr) {
          arr.forEach(function(v) {
            list.push(v);
            if (v.children) { walk(v.children); }
          });
        })(nonPositioned.concat(floated, positioned));

        list.forEach(function(v) {
          if (v.context) {
            sortZ(v.context);
          } else {
            queue.push(v.node);
          }
        });
      });
    }

    sortZ(rootContext);

    return queue;
  }

  function getRenderer(rendererName) {
    var renderer;

    if (typeof options.renderer === "string" && _html2canvas.Renderer[rendererName] !== undefined) {
      renderer = _html2canvas.Renderer[rendererName](options);
    } else if (typeof rendererName === "function") {
      renderer = rendererName(options);
    } else {
      throw new Error("Unknown renderer");
    }

    if ( typeof renderer !== "function" ) {
      throw new Error("Invalid renderer defined");
    }
    return renderer;
  }

  return getRenderer(options.renderer)(parseQueue, options, document, createRenderQueue(parseQueue.stack), _html2canvas);
};

_html2canvas.Util.Support = function (options, doc) {

  function supportSVGRendering() {
    var img = new Image(),
    canvas = doc.createElement("canvas"),
    ctx = (canvas.getContext === undefined) ? false : canvas.getContext("2d");
    if (ctx === false) {
      return false;
    }
    canvas.width = canvas.height = 10;
    img.src = [
    "data:image/svg+xml,",
    "<svg xmlns='http://www.w3.org/2000/svg' width='10' height='10'>",
    "<foreignObject width='10' height='10'>",
    "<div xmlns='http://www.w3.org/1999/xhtml' style='width:10;height:10;'>",
    "sup",
    "</div>",
    "</foreignObject>",
    "</svg>"
    ].join("");
    try {
      ctx.drawImage(img, 0, 0);
      canvas.toDataURL();
    } catch(e) {
      return false;
    }
    _html2canvas.Util.log('html2canvas: Parse: SVG powered rendering available');
    return true;
  }

  // Test whether we can use ranges to measure bounding boxes
  // Opera doesn't provide valid bounds.height/bottom even though it supports the method.

  function supportRangeBounds() {
    var r, testElement, rangeBounds, rangeHeight, support = false;

    if (doc.createRange) {
      r = doc.createRange();
      if (r.getBoundingClientRect) {
        testElement = doc.createElement('boundtest');
        testElement.style.height = "123px";
        testElement.style.display = "block";
        doc.body.appendChild(testElement);

        r.selectNode(testElement);
        rangeBounds = r.getBoundingClientRect();
        rangeHeight = rangeBounds.height;

        if (rangeHeight === 123) {
          support = true;
        }
        doc.body.removeChild(testElement);
      }
    }

    return support;
  }

  return {
    rangeBounds: supportRangeBounds(),
    svgRendering: options.svgRendering && supportSVGRendering()
  };
};
window.html2canvas = function(elements, opts) {
  elements = (elements.length) ? elements : [elements];
  var queue,
  canvas,
  options = {
    // general
    logging: false,
    elements: elements,
    background: "#fff",

    // preload options
    proxy: null,
    timeout: 0,    // no timeout
    useCORS: false, // try to load images as CORS (where available), before falling back to proxy
    allowTaint: false, // whether to allow images to taint the canvas, won't need proxy if set to true

    // parse options
    svgRendering: false, // use svg powered rendering where available (FF11+)
    ignoreElements: "IFRAME|OBJECT|PARAM",
    useOverflow: true,
    letterRendering: false,
    chinese: false,
    async: false, // If true, parsing will not block, but if the user scrolls during parse the image can get weird

    // render options
    width: null,
    height: null,
    taintTest: true, // do a taint test with all images before applying to canvas
    renderer: "Canvas"
  };

  options = _html2canvas.Util.Extend(opts, options);

  _html2canvas.logging = options.logging;
  options.complete = function( images ) {

    if (typeof options.onpreloaded === "function") {
      if ( options.onpreloaded( images ) === false ) {
        return;
      }
    }
    _html2canvas.Parse( images, options, function(queue) {
      if (typeof options.onparsed === "function") {
        if ( options.onparsed( queue ) === false ) {
          return;
        }
      }

      canvas = _html2canvas.Renderer( queue, options );

      if (typeof options.onrendered === "function") {
        options.onrendered( canvas );
      }
    });
  };

  // for pages without images, we still want this to be async, i.e. return methods before executing
  window.setTimeout( function(){
    _html2canvas.Preload( options );
  }, 0 );

  return {
    render: function( queue, opts ) {
      return _html2canvas.Renderer( queue, _html2canvas.Util.Extend(opts, options) );
    },
    parse: function( images, opts ) {
      return _html2canvas.Parse( images, _html2canvas.Util.Extend(opts, options) );
    },
    preload: function( opts ) {
      return _html2canvas.Preload( _html2canvas.Util.Extend(opts, options) );
    },
    log: _html2canvas.Util.log
  };
};

window.html2canvas.log = _html2canvas.Util.log; // for renderers
window.html2canvas.Renderer = {
  Canvas: undefined // We are assuming this will be used
};
_html2canvas.Renderer.Canvas = function(options) {
  options = options || {};

  var doc = document,
  safeImages = [],
  testCanvas = document.createElement("canvas"),
  testctx = testCanvas.getContext("2d"),
  Util = _html2canvas.Util,
  canvas = options.canvas || doc.createElement('canvas');

  function createShape(ctx, args) {
    ctx.beginPath();
    args.forEach(function(arg) {
      ctx[arg.name].apply(ctx, arg['arguments']);
    });
    ctx.closePath();
  }

  function safeImage(item) {
    if (safeImages.indexOf(item['arguments'][0].src) === -1) {
      testctx.drawImage(item['arguments'][0], 0, 0);
      try {
        testctx.getImageData(0, 0, 1, 1);
      } catch(e) {
        testCanvas = doc.createElement("canvas");
        testctx = testCanvas.getContext("2d");
        return false;
      }
      safeImages.push(item['arguments'][0].src);
    }
    return true;
  }

  function renderItem(ctx, item) {
    switch(item.type){
      case "variable":
        ctx[item.name] = item['arguments'];
        break;
      case "function":
        switch(item.name) {
          case "createPattern":
            if (item['arguments'][0].width > 0 && item['arguments'][0].height > 0) {
              try {
                ctx.fillStyle = ctx.createPattern(item['arguments'][0], "repeat");
              } catch(e) {
                Util.log("html2canvas: Renderer: Error creating pattern", e.message);
              }
            }
            break;
          case "drawShape":
            createShape(ctx, item['arguments']);
            break;
          case "drawImage":
            if (item['arguments'][8] > 0 && item['arguments'][7] > 0) {
              if (!options.taintTest || (options.taintTest && safeImage(item))) {
                ctx.drawImage.apply( ctx, item['arguments'] );
              }
            }
            break;
          default:
            ctx[item.name].apply(ctx, item['arguments']);
        }
        break;
    }
  }

  return function(parsedData, options, document, queue, _html2canvas) {
    var ctx = canvas.getContext("2d"),
    newCanvas,
    bounds,
    fstyle,
    zStack = parsedData.stack;

    canvas.width = canvas.style.width =  options.width || zStack.ctx.width;
    canvas.height = canvas.style.height = options.height || zStack.ctx.height;

    fstyle = ctx.fillStyle;
    ctx.fillStyle = (Util.isTransparent(parsedData.backgroundColor) && options.background !== undefined) ? options.background : parsedData.backgroundColor;
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    ctx.fillStyle = fstyle;
    queue.forEach(function(storageContext) {
      // set common settings for canvas
      ctx.textBaseline = "bottom";
      ctx.save();

      if (storageContext.transform.matrix) {
        ctx.translate(storageContext.transform.origin[0], storageContext.transform.origin[1]);
        ctx.transform.apply(ctx, storageContext.transform.matrix);
        ctx.translate(-storageContext.transform.origin[0], -storageContext.transform.origin[1]);
      }

      if (storageContext.clip){
        ctx.beginPath();
        ctx.rect(storageContext.clip.left, storageContext.clip.top, storageContext.clip.width, storageContext.clip.height);
        ctx.clip();
      }

      if (storageContext.ctx.storage) {
        storageContext.ctx.storage.forEach(function(item) {
          renderItem(ctx, item);
        });
      }

      ctx.restore();
    });

    Util.log("html2canvas: Renderer: Canvas renderer done - returning canvas obj");

    if (options.elements.length === 1) {
      if (typeof options.elements[0] === "object" && options.elements[0].nodeName !== "BODY") {
        // crop image to the bounds of selected (single) element
        bounds = _html2canvas.Util.Bounds(options.elements[0]);
        newCanvas = document.createElement('canvas');
        newCanvas.width = Math.ceil(bounds.width);
        newCanvas.height = Math.ceil(bounds.height);
        ctx = newCanvas.getContext("2d");

        ctx.drawImage(canvas, bounds.left, bounds.top, bounds.width, bounds.height, 0, 0, bounds.width, bounds.height);
        canvas = null;
        return newCanvas;
      }
    }

    return canvas;
  };
};
})(window,document);

/*!
 * jquery.confirm
 *
 * @version 2.0.1
 *
 * @author My C-Labs
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 * @author Russel Vela
 *
 * @license MIT
 * @url http://myclabs.github.io/jquery.confirm/
 */
(function($){$.fn.confirm=function(options){if(typeof options==="undefined"){options={}}this.click(function(e){e.preventDefault();var newOptions=$.extend({button:$(this)},options);$.confirm(newOptions,e)});return this};$.confirm=function(options,e){var settings=$.extend({text:"Are you sure?",title:"",confirmButton:"Yes",cancelButton:"Cancel",post:false,confirm:function(o){var url=e.currentTarget.attributes["href"].value;if(options.post){var form=$('<form method="post" class="hide" action="'+url+'"></form>');$("body").append(form);form.submit()}else{window.location=url}},cancel:function(o){},button:null},options);var modalHeader="";if(settings.title!==""){modalHeader="<div class=modal-header>"+'<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>'+'<h4 class="modal-title">'+settings.title+"</h4>"+"</div>"}var modalHTML='<div class="confirmation-modal modal fade" tabindex="-1" role="dialog">'+'<div class="modal-dialog">'+'<div class="modal-content">'+modalHeader+'<div class="modal-body">'+settings.text+"</div>"+'<div class="modal-footer">'+'<button class="confirm btn btn-primary" type="button" data-dismiss="modal">'+settings.confirmButton+"</button>"+'<button class="cancel btn btn-default" type="button" data-dismiss="modal">'+settings.cancelButton+"</div>"+"</div>"+"</div>"+"</div>"+"</div>";var modal=$(modalHTML);modal.on("shown",function(){modal.find(".btn-primary:first").focus()});modal.on("hidden",function(){modal.remove()});modal.find(".confirm").click(function(){settings.confirm(settings.button)});modal.find(".cancel").click(function(){settings.cancel(settings.button)});$("body").append(modal);modal.modal("show")}})(jQuery);

//Side-Comments
function require(e,t,n){var r=require.resolve(e);if(null==r){n=n||e,t=t||"root";var o=new Error('Failed to require "'+n+'" from "'+t+'"');throw o.path=n,o.parent=t,o.require=!0,o}var i=require.modules[r];if(!i._resolving&&!i.exports){var s={};s.exports={},s.client=s.component=!0,i._resolving=!0,i.call(this,s.exports,require.relative(r),s),delete i._resolving,i.exports=s.exports}return i.exports}require.modules={},require.aliases={},require.resolve=function(e){"/"===e.charAt(0)&&(e=e.slice(1));for(var t=[e,e+".js",e+".json",e+"/index.js",e+"/index.json"],n=0;n<t.length;n++){var e=t[n];if(require.modules.hasOwnProperty(e))return e;if(require.aliases.hasOwnProperty(e))return require.aliases[e]}},require.normalize=function(e,t){var n=[];if("."!=t.charAt(0))return t;e=e.split("/"),t=t.split("/");for(var r=0;r<t.length;++r)".."==t[r]?e.pop():"."!=t[r]&&""!=t[r]&&n.push(t[r]);return e.concat(n).join("/")},require.register=function(e,t){require.modules[e]=t},require.alias=function(e,t){if(!require.modules.hasOwnProperty(e))throw new Error('Failed to alias "'+e+'", it does not exist');require.aliases[t]=e},require.relative=function(e){function t(e,t){for(var n=e.length;n--;)if(e[n]===t)return n;return-1}function n(t){var r=n.resolve(t);return require(r,e,t)}var r=require.normalize(e,"..");return n.resolve=function(n){var o=n.charAt(0);if("/"==o)return n.slice(1);if("."==o)return require.normalize(r,n);var i=e.split("/"),s=t(i,"deps")+1;return s||(s=0),n=i.slice(0,s+1).join("/")+"/deps/"+n},n.exists=function(e){return require.modules.hasOwnProperty(n.resolve(e))},n},require.register("component-emitter/index.js",function(e,t,n){function r(e){return e?o(e):void 0}function o(e){for(var t in r.prototype)e[t]=r.prototype[t];return e}n.exports=r,r.prototype.on=r.prototype.addEventListener=function(e,t){return this._callbacks=this._callbacks||{},(this._callbacks[e]=this._callbacks[e]||[]).push(t),this},r.prototype.once=function(e,t){function n(){r.off(e,n),t.apply(this,arguments)}var r=this;return this._callbacks=this._callbacks||{},n.fn=t,this.on(e,n),this},r.prototype.off=r.prototype.removeListener=r.prototype.removeAllListeners=r.prototype.removeEventListener=function(e,t){if(this._callbacks=this._callbacks||{},0==arguments.length)return this._callbacks={},this;var n=this._callbacks[e];if(!n)return this;if(1==arguments.length)return delete this._callbacks[e],this;for(var r,o=0;o<n.length;o++)if(r=n[o],r===t||r.fn===t){n.splice(o,1);break}return this},r.prototype.emit=function(e){this._callbacks=this._callbacks||{};var t=[].slice.call(arguments,1),n=this._callbacks[e];if(n){n=n.slice(0);for(var r=0,o=n.length;o>r;++r)n[r].apply(this,t)}return this},r.prototype.listeners=function(e){return this._callbacks=this._callbacks||{},this._callbacks[e]||[]},r.prototype.hasListeners=function(e){return!!this.listeners(e).length}}),require.register("side-comments/js/main.js",function(e,t,n){function r(e,t,n){this.$el=a(e),this.$body=a("body"),this.eventPipe=new s,this.currentUser=o.clone(t)||null,this.existingComments=o.cloneDeep(n)||[],this.sections=[],this.activeSection=null,this.eventPipe.on("showComments",o.bind(this.showComments,this)),this.eventPipe.on("hideComments",o.bind(this.hideComments,this)),this.eventPipe.on("sectionSelected",o.bind(this.sectionSelected,this)),this.eventPipe.on("sectionDeselected",o.bind(this.sectionDeselected,this)),this.eventPipe.on("commentPosted",o.bind(this.commentPosted,this)),this.eventPipe.on("commentDeleted",o.bind(this.commentDeleted,this)),this.eventPipe.on("addCommentAttempted",o.bind(this.addCommentAttempted,this)),this.$body.on("click",o.bind(this.bodyClick,this)),this.initialize(this.existingComments)}var o=t("./vendor/lodash-custom.js"),i=t("./section.js"),s=t("emitter"),a=jQuery;s(r.prototype),r.prototype.initialize=function(){o.each(this.$el.find(".commentable-section"),function(e){var t=a(e),n=t.data("section-id").toString(),r=o.find(this.existingComments,{sectionId:n});this.sections.push(new i(this.eventPipe,t,this.currentUser,r))},this)},r.prototype.showComments=function(){this.$el.addClass("side-comments-open")},r.prototype.hideComments=function(){this.activeSection&&(this.activeSection.deselect(),this.activeSection=null),this.$el.removeClass("side-comments-open")},r.prototype.sectionSelected=function(e){this.showComments(),this.activeSection&&this.activeSection.deselect(),this.activeSection=e},r.prototype.sectionDeselected=function(){this.hideComments(),this.activeSection=null},r.prototype.commentPosted=function(e){this.emit("commentPosted",e)},r.prototype.commentDeleted=function(e){this.emit("commentDeleted",e)},r.prototype.addCommentAttempted=function(){this.emit("addCommentAttempted")},r.prototype.insertComment=function(e){var t=o.find(this.sections,{id:e.sectionId});t.insertComment(e)},r.prototype.removeComment=function(e,t){var n=o.find(this.sections,{id:e});n.removeComment(t)},r.prototype.deleteComment=function(e,t){var n=o.find(this.sections,{id:e});n.deleteComment(t)},r.prototype.commentsAreVisible=function(){return this.$el.hasClass("side-comments-open")},r.prototype.bodyClick=function(e){var t=a(e.target);t.closest(".side-comment").length<1&&t.closest("body").length>0&&(this.activeSection&&this.activeSection.deselect(),this.hideComments())},r.prototype.setCurrentUser=function(e){this.hideComments(),this.currentUser=e,o.each(this.sections,o.bind(function(e){e.currentUser=this.currentUser,e.render()},this))},r.prototype.removeCurrentUser=function(){this.setCurrentUser(null)},r.prototype.destroy=function(){this.hideComments(),this.$el.off()},n.exports=r}),require.register("side-comments/js/section.js",function(e,t,n){function r(e,t,n,r){this.eventPipe=e,this.$el=t,this.comments=r?r.comments:[],this.currentUser=n||null,this.clickEventName=a()?"touchstart":"click",this.id=t.data("section-id"),this.$el.on(this.clickEventName,".side-comment .marker",o.bind(this.markerClick,this)),this.$el.on(this.clickEventName,".side-comment .add-comment",o.bind(this.addCommentClick,this)),this.$el.on(this.clickEventName,".side-comment .post",o.bind(this.postCommentClick,this)),this.$el.on(this.clickEventName,".side-comment .cancel",o.bind(this.cancelCommentClick,this)),this.$el.on(this.clickEventName,".side-comment .delete",o.bind(this.deleteCommentClick,this)),this.render()}var o=t("./vendor/lodash-custom.js"),i=t("../templates/section.html"),s=t("../templates/comment.html"),a=t("./helpers/mobile-check.js"),c=jQuery;r.prototype.markerClick=function(e){e.preventDefault(),this.select()},r.prototype.addCommentClick=function(e){e.preventDefault(),this.currentUser?this.showCommentForm():this.eventPipe.emit("addCommentAttempted")},r.prototype.showCommentForm=function(){this.comments.length>0&&(this.$el.find(".add-comment").addClass("hide"),this.$el.find(".comment-form").addClass("active")),this.focusCommentBox()},r.prototype.hideCommentForm=function(){this.comments.length>0&&(this.$el.find(".add-comment").removeClass("hide"),this.$el.find(".comment-form").removeClass("active")),this.$el.find(".comment-box").empty()},r.prototype.focusCommentBox=function(){setTimeout(o.bind(function(){this.$el.find(".comment-box").get(0).focus()},this),300)},r.prototype.cancelCommentClick=function(e){e.preventDefault(),this.cancelComment()},r.prototype.cancelComment=function(){this.comments.length>0?this.hideCommentForm():(this.deselect(),this.eventPipe.emit("hideComments"))},r.prototype.postCommentClick=function(e){e.preventDefault(),this.postComment()},r.prototype.postComment=function(){var e=this.$el.find(".comment-box"),t=e.val(),n={sectionId:this.id,comment:t,authorAvatarUrl:this.currentUser.avatarUrl,authorName:this.currentUser.name,authorId:this.currentUser.id,authorUrl:this.currentUser.authorUrl||null};e.val(""),this.eventPipe.emit("commentPosted",n)},r.prototype.insertComment=function(e){this.comments.push(e);var t=o.template(s,{comment:e,currentUser:this.currentUser});this.$el.find(".comments").append(t),this.$el.find(".side-comment").addClass("has-comments"),this.updateCommentCount(),this.hideCommentForm()},r.prototype.updateCommentCount=function(){this.$el.find(".marker span").text(this.comments.length)},r.prototype.deleteCommentClick=function(e){e.preventDefault();var t=c(e.target).closest("li").data("comment-id");window.confirm("Are you sure you want to delete this comment?")&&this.deleteComment(t)},r.prototype.deleteComment=function(e){var t=o.find(this.comments,{id:e});t.sectionId=this.id,this.eventPipe.emit("commentDeleted",t)},r.prototype.removeComment=function(e){this.comments=o.reject(this.comments,{id:e}),this.$el.find('.side-comment .comments li[data-comment-id="'+e+'"]').remove(),this.updateCommentCount(),this.comments.length<1&&this.$el.find(".side-comment").removeClass("has-comments")},r.prototype.select=function(){this.isSelected()?(this.deselect(),this.eventPipe.emit("sectionDeselected",this)):(this.$el.find(".side-comment").addClass("active"),0===this.comments.length&&this.currentUser&&this.focusCommentBox(),this.eventPipe.emit("sectionSelected",this))},r.prototype.deselect=function(){this.$el.find(".side-comment").removeClass("active"),this.hideCommentForm()},r.prototype.isSelected=function(){return this.$el.find(".side-comment").hasClass("active")},r.prototype.sectionClasses=function(){var e="";return this.comments.length>0&&(e+=" has-comments"),this.currentUser||(e+=" no-current-user"),e},r.prototype.render=function(){this.$el.find(".side-comment").remove(),c(o.template(i,{commentTemplate:s,comments:this.comments,sectionClasses:this.sectionClasses(),currentUser:this.currentUser})).appendTo(this.$el)},r.prototype.destroy=function(){this.$el.off()},n.exports=r}),require.register("side-comments/js/vendor/lodash-custom.js",function(e,t,n){(function(){function t(e){return"\\"+ht[e]}function r(){return z.pop()||[]}function o(e){return"function"!=typeof e.toString&&"string"==typeof(e+"")}function i(e){e.length=0,z.length<T&&z.push(e)}function s(e,t,n){t||(t=0),"undefined"==typeof n&&(n=e?e.length:0);for(var r=-1,o=n-t||0,i=Array(0>o?0:o);++r<o;)i[r]=e[t+r];return i}function a(){}function c(e){function t(){if(r){var e=s(r);St.apply(e,arguments)}if(this instanceof t){var i=u(n.prototype),a=n.apply(i,e||arguments);return w(a)?a:i}return n.apply(o,e||arguments)}var n=e[0],r=e[2],o=e[4];return zt(t,e),t}function l(e,t,n,a,c){if(n){var u=n(e);if("undefined"!=typeof u)return u}var m=w(e);if(!m)return e;var p=wt.call(e);if(!lt[p]||!It.nodeClass&&o(e))return e;var h=Dt[p];switch(p){case tt:case nt:return new h(+e);case it:case ct:return new h(e);case at:return u=h(e.source,V.exec(e)),u.lastIndex=e.lastIndex,u}var f=Ft(e);if(t){var d=!a;a||(a=r()),c||(c=r());for(var g=a.length;g--;)if(a[g]==e)return c[g];u=f?h(e.length):{}}else u=f?s(e):Jt({},e);return f&&(Pt.call(e,"index")&&(u.index=e.index),Pt.call(e,"input")&&(u.input=e.input)),t?(a.push(e),c.push(u),(f?Gt:Xt)(e,function(e,r){u[r]=l(e,t,n,a,c)}),d&&(i(a),i(c)),u):u}function u(e){return w(e)?At(e):{}}function m(e,t,n){if("function"!=typeof e)return O;if("undefined"==typeof t||!("prototype"in e))return e;var r=e.__bindData__;if("undefined"==typeof r&&(It.funcNames&&(r=!e.name),r=r||!It.funcDecomp,!r)){var o=jt.call(e);It.funcNames||(r=!W.test(o)),r||(r=K.test(o),zt(e,r))}if(r===!1||r!==!0&&1&r[1])return e;switch(n){case 1:return function(n){return e.call(t,n)};case 2:return function(n,r){return e.call(t,n,r)};case 3:return function(n,r,o){return e.call(t,n,r,o)};case 4:return function(n,r,o,i){return e.call(t,n,r,o,i)}}return q(e,t)}function p(e){function t(){var e=l?a:this;if(o){var g=s(o);St.apply(g,arguments)}if((i||h)&&(g||(g=s(arguments)),i&&St.apply(g,i),h&&g.length<c))return r|=16,p([n,f?r:-4&r,g,null,a,c]);if(g||(g=arguments),m&&(n=e[d]),this instanceof t){e=u(n.prototype);var v=n.apply(e,g);return w(v)?v:e}return n.apply(e,g)}var n=e[0],r=e[1],o=e[2],i=e[3],a=e[4],c=e[5],l=1&r,m=2&r,h=4&r,f=8&r,d=n;return zt(t,e),t}function h(e,t,n,s,a,c){if(n){var l=n(e,t);if("undefined"!=typeof l)return!!l}if(e===t)return 0!==e||1/e==1/t;var u=typeof e,m=typeof t;if(!(e!==e||e&&pt[u]||t&&pt[m]))return!1;if(null==e||null==t)return e===t;var p=wt.call(e),f=wt.call(t);if(p==Z&&(p=st),f==Z&&(f=st),p!=f)return!1;switch(p){case tt:case nt:return+e==+t;case it:return e!=+e?t!=+t:0==e?1/e==1/t:e==+t;case at:case ct:return e==String(t)}var d=p==et;if(!d){var g=Pt.call(e,"__wrapped__"),v=Pt.call(t,"__wrapped__");if(g||v)return h(g?e.__wrapped__:e,v?t.__wrapped__:t,n,s,a,c);if(p!=st||!It.nodeClass&&(o(e)||o(t)))return!1;var y=!It.argsObject&&b(e)?Object:e.constructor,C=!It.argsObject&&b(t)?Object:t.constructor;if(y!=C&&!(x(y)&&y instanceof y&&x(C)&&C instanceof C)&&"constructor"in e&&"constructor"in t)return!1}var k=!a;a||(a=r()),c||(c=r());for(var w=a.length;w--;)if(a[w]==e)return c[w]==t;var _=0;if(l=!0,a.push(e),c.push(t),d){if(w=e.length,_=t.length,l=_==w,l||s)for(;_--;){var j=w,P=t[_];if(s)for(;j--&&!(l=h(e[j],P,n,s,a,c)););else if(!(l=h(e[_],P,n,s,a,c)))break}}else Mt(t,function(t,r,o){return Pt.call(o,r)?(_++,l=Pt.call(e,r)&&h(e[r],t,n,s,a,c)):void 0}),l&&!s&&Mt(e,function(e,t,n){return Pt.call(n,t)?l=--_>-1:void 0});return a.pop(),c.pop(),k&&(i(a),i(c)),l}function f(e,t,n,r,o,i){var a=1&t,l=2&t,u=4&t,m=16&t,h=32&t;if(!l&&!x(e))throw new TypeError;m&&!n.length&&(t&=-17,m=n=!1),h&&!r.length&&(t&=-33,h=r=!1);var d=e&&e.__bindData__;if(d&&d!==!0)return d=s(d),d[2]&&(d[2]=s(d[2])),d[3]&&(d[3]=s(d[3])),!a||1&d[1]||(d[4]=o),!a&&1&d[1]&&(t|=8),!u||4&d[1]||(d[5]=i),m&&St.apply(d[2]||(d[2]=[]),n),h&&Et.apply(d[3]||(d[3]=[]),r),d[1]|=t,f.apply(null,d);var g=1==t||17===t?c:p;return g([e,t,n,r,o,i])}function d(){mt.shadowedProps=X,mt.array=mt.bottom=mt.loop=mt.top="",mt.init="iterable",mt.useHas=!0;for(var e,t=0;e=arguments[t];t++)for(var n in e)mt[n]=e[n];var r=mt.args;mt.firstArg=/^[^,]+/.exec(r)[0];var o=Function("baseCreateCallback, errorClass, errorProto, hasOwnProperty, indicatorObject, isArguments, isArray, isString, keys, objectProto, objectTypes, nonEnumProps, stringClass, stringProto, toString","return function("+r+") {\n"+Nt(mt)+"\n}");return o(m,rt,Ct,Pt,F,b,Ft,_,mt.keys,kt,pt,Lt,ct,xt,wt)}function g(e){return Vt[e]}function v(e){return"function"==typeof e&&_t.test(e)}function b(e){return e&&"object"==typeof e&&"number"==typeof e.length&&wt.call(e)==Z||!1}function y(e,t,n,r){return"boolean"!=typeof t&&null!=t&&(r=n,n=t,t=!1),l(e,t,"function"==typeof n&&m(n,r,1))}function C(e,t,n){return l(e,!0,"function"==typeof t&&m(t,n,1))}function x(e){return"function"==typeof e}function w(e){return!(!e||!pt[typeof e])}function _(e){return"string"==typeof e||e&&"object"==typeof e&&wt.call(e)==ct||!1}function j(e){for(var t=-1,n=Rt(e),r=n.length,o=Array(r);++t<r;)o[t]=e[n[t]];return o}function P(e,t,n){var r=[];if(t=a.createCallback(t,n,3),Ft(e))for(var o=-1,i=e.length;++o<i;){var s=e[o];t(s,o,e)&&r.push(s)}else Gt(e,function(e,n,o){t(e,n,o)&&r.push(e)});return r}function S(e,t,n){if(t=a.createCallback(t,n,3),!Ft(e)){var r;return Gt(e,function(e,n,o){return t(e,n,o)?(r=e,!1):void 0}),r}for(var o=-1,i=e.length;++o<i;){var s=e[o];if(t(s,o,e))return s}}function $(e,t,n){if(t&&"undefined"==typeof n&&Ft(e))for(var r=-1,o=e.length;++r<o&&t(e[r],r,e)!==!1;);else Gt(e,t,n);return e}function E(e,t,n){return t=a.createCallback(t,n,3),P(e,function(e,n,r){return!t(e,n,r)})}function q(e,t){return arguments.length>2?f(e,17,s(arguments,2),null,t):f(e,1,null,null,t)}function A(e,t,n){var r=typeof e;if(null==e||"function"==r)return m(e,t,n);if("object"!=r)return L(e);var o=Rt(e),i=o[0],s=e[i];return 1!=o.length||s!==s||w(s)?function(t){for(var n=o.length,r=!1;n--&&(r=h(t[o[n]],e[o[n]],null,!0)););return r}:function(e){var t=e[i];return s===t&&(0!==s||1/s==1/t)}}function U(e){return null==e?"":String(e).replace(Wt,g)}function O(e){return e}function D(){}function L(e){return function(t){return t[e]}}function I(e,n,r){var o=a.templateSettings;e=String(e||""),r=Kt({},r,o);var i,s=Kt({},r.imports,o.imports),c=Rt(s),l=j(s),u=0,m=r.interpolate||J,p="__p += '",h=RegExp((r.escape||J).source+"|"+m.source+"|"+(m===G?Q:J).source+"|"+(r.evaluate||J).source+"|$","g");e.replace(h,function(n,r,o,s,a,c){return o||(o=s),p+=e.slice(u,c).replace(M,t),r&&(p+="' +\n__e("+r+") +\n'"),a&&(i=!0,p+="';\n"+a+";\n__p += '"),o&&(p+="' +\n((__t = ("+o+")) == null ? '' : __t) +\n'"),u=c+n.length,n}),p+="';\n";var f=r.variable,d=f;d||(f="obj",p="with ("+f+") {\n"+p+"\n}\n"),p=(i?p.replace(R,""):p).replace(H,"$1").replace(B,"$1;"),p="function("+f+") {\n"+(d?"":f+" || ("+f+" = {});\n")+"var __t, __p = '', __e = _.escape"+(i?", __j = Array.prototype.join;\nfunction print() { __p += __j.call(arguments, '') }\n":";\n")+p+"return __p\n}";var g="\n/*\n//# sourceURL="+(r.sourceURL||"/lodash/template/source["+Y++ +"]")+"\n*/";try{var v=Function(c,"return "+p+g).apply(N,l)}catch(b){throw b.source=p,b}return n?v(n):(v.source=p,v)}var N,z=[],F={},T=40,R=/\b__p \+= '';/g,H=/\b(__p \+=) '' \+/g,B=/(__e\(.*?\)|\b__t\)) \+\n'';/g,Q=/\$\{([^\\}]*(?:\\.[^\\}]*)*)\}/g,V=/\w*$/,W=/^\s*function[ \n\r\t]+\w/,G=/<%=([\s\S]+?)%>/g,J=/($^)/,K=/\bthis\b/,M=/['\n\r\t\u2028\u2029\\]/g,X=["constructor","hasOwnProperty","isPrototypeOf","propertyIsEnumerable","toLocaleString","toString","valueOf"],Y=0,Z="[object Arguments]",et="[object Array]",tt="[object Boolean]",nt="[object Date]",rt="[object Error]",ot="[object Function]",it="[object Number]",st="[object Object]",at="[object RegExp]",ct="[object String]",lt={};lt[ot]=!1,lt[Z]=lt[et]=lt[tt]=lt[nt]=lt[it]=lt[st]=lt[at]=lt[ct]=!0;var ut={configurable:!1,enumerable:!1,value:null,writable:!1},mt={args:"",array:null,bottom:"",firstArg:"",init:"",keys:null,loop:"",shadowedProps:null,support:null,top:"",useHas:!1},pt={"boolean":!1,"function":!0,object:!0,number:!1,string:!1,undefined:!1},ht={"\\":"\\","'":"'","\n":"n","\r":"r","	":"t","\u2028":"u2028","\u2029":"u2029"},ft=pt[typeof window]&&window||this,dt=pt[typeof e]&&e&&!e.nodeType&&e,gt=pt[typeof n]&&n&&!n.nodeType&&n,vt=gt&&gt.exports===dt&&dt,bt=pt[typeof global]&&global;!bt||bt.global!==bt&&bt.window!==bt||(ft=bt);var yt=[],Ct=Error.prototype,kt=Object.prototype,xt=String.prototype,wt=kt.toString,_t=RegExp("^"+String(wt).replace(/[.*+?^${}()|[\]\\]/g,"\\$&").replace(/toString| for [^\]]+/g,".*?")+"$"),jt=Function.prototype.toString,Pt=kt.hasOwnProperty,St=yt.push,$t=kt.propertyIsEnumerable,Et=yt.unshift,qt=function(){try{var e={},t=v(t=Object.defineProperty)&&t,n=t(e,e,e)&&t}catch(r){}return n}(),At=v(At=Object.create)&&At,Ut=v(Ut=Array.isArray)&&Ut,Ot=v(Ot=Object.keys)&&Ot,Dt={};Dt[et]=Array,Dt[tt]=Boolean,Dt[nt]=Date,Dt[ot]=Function,Dt[st]=Object,Dt[it]=Number,Dt[at]=RegExp,Dt[ct]=String;var Lt={};Lt[et]=Lt[nt]=Lt[it]={constructor:!0,toLocaleString:!0,toString:!0,valueOf:!0},Lt[tt]=Lt[ct]={constructor:!0,toString:!0,valueOf:!0},Lt[rt]=Lt[ot]=Lt[at]={constructor:!0,toString:!0},Lt[st]={constructor:!0},function(){for(var e=X.length;e--;){var t=X[e];for(var n in Lt)Pt.call(Lt,n)&&!Pt.call(Lt[n],t)&&(Lt[n][t]=!1)}}();var It=a.support={};!function(){var e=function(){this.x=1},t={0:1,length:1},n=[];e.prototype={valueOf:1,y:1};for(var r in new e)n.push(r);for(r in arguments);It.argsClass=wt.call(arguments)==Z,It.argsObject=arguments.constructor==Object&&!(arguments instanceof Array),It.enumErrorProps=$t.call(Ct,"message")||$t.call(Ct,"name"),It.enumPrototypes=$t.call(e,"prototype"),It.funcDecomp=!v(ft.WinRTError)&&K.test(function(){return this}),It.funcNames="string"==typeof Function.name,It.nonEnumArgs=0!=r,It.nonEnumShadows=!/valueOf/.test(n),It.spliceObjects=(yt.splice.call(t,0,1),!t[0]),It.unindexedChars="x"[0]+Object("x")[0]!="xx";try{It.nodeClass=!(wt.call(document)==st&&!({toString:0}+""))}catch(o){It.nodeClass=!0}}(1),a.templateSettings={escape:/<%-([\s\S]+?)%>/g,evaluate:/<%([\s\S]+?)%>/g,interpolate:G,variable:"",imports:{_:a}};var Nt=function(e){var t="var index, iterable = "+e.firstArg+", result = "+e.init+";\nif (!iterable) return result;\n"+e.top+";";e.array?(t+="\nvar length = iterable.length; index = -1;\nif ("+e.array+") {  ",It.unindexedChars&&(t+="\n  if (isString(iterable)) {\n    iterable = iterable.split('')\n  }  "),t+="\n  while (++index < length) {\n    "+e.loop+";\n  }\n}\nelse {  "):It.nonEnumArgs&&(t+="\n  var length = iterable.length; index = -1;\n  if (length && isArguments(iterable)) {\n    while (++index < length) {\n      index += '';\n      "+e.loop+";\n    }\n  } else {  "),It.enumPrototypes&&(t+="\n  var skipProto = typeof iterable == 'function';\n  "),It.enumErrorProps&&(t+="\n  var skipErrorProps = iterable === errorProto || iterable instanceof Error;\n  ");var n=[];if(It.enumPrototypes&&n.push('!(skipProto && index == "prototype")'),It.enumErrorProps&&n.push('!(skipErrorProps && (index == "message" || index == "name"))'),e.useHas&&e.keys)t+="\n  var ownIndex = -1,\n      ownProps = objectTypes[typeof iterable] && keys(iterable),\n      length = ownProps ? ownProps.length : 0;\n\n  while (++ownIndex < length) {\n    index = ownProps[ownIndex];\n",n.length&&(t+="    if ("+n.join(" && ")+") {\n  "),t+=e.loop+";    ",n.length&&(t+="\n    }"),t+="\n  }  ";else if(t+="\n  for (index in iterable) {\n",e.useHas&&n.push("hasOwnProperty.call(iterable, index)"),n.length&&(t+="    if ("+n.join(" && ")+") {\n  "),t+=e.loop+";    ",n.length&&(t+="\n    }"),t+="\n  }    ",It.nonEnumShadows){for(t+="\n\n  if (iterable !== objectProto) {\n    var ctor = iterable.constructor,\n        isProto = iterable === (ctor && ctor.prototype),\n        className = iterable === stringProto ? stringClass : iterable === errorProto ? errorClass : toString.call(iterable),\n        nonEnum = nonEnumProps[className];\n      ",k=0;7>k;k++)t+="\n    index = '"+e.shadowedProps[k]+"';\n    if ((!(isProto && nonEnum[index]) && hasOwnProperty.call(iterable, index))",e.useHas||(t+=" || (!nonEnum[index] && iterable[index] !== objectProto[index])"),t+=") {\n      "+e.loop+";\n    }      ";t+="\n  }    "}return(e.array||It.nonEnumArgs)&&(t+="\n}"),t+=e.bottom+";\nreturn result"};At||(u=function(){function e(){}return function(t){if(w(t)){e.prototype=t;var n=new e;e.prototype=null}return n||ft.Object()}}());var zt=qt?function(e,t){ut.value=t,qt(e,"__bindData__",ut)}:D;It.argsClass||(b=function(e){return e&&"object"==typeof e&&"number"==typeof e.length&&Pt.call(e,"callee")&&!$t.call(e,"callee")||!1});var Ft=Ut||function(e){return e&&"object"==typeof e&&"number"==typeof e.length&&wt.call(e)==et||!1},Tt=d({args:"object",init:"[]",top:"if (!(objectTypes[typeof object])) return result",loop:"result.push(index)"}),Rt=Ot?function(e){return w(e)?It.enumPrototypes&&"function"==typeof e||It.nonEnumArgs&&e.length&&b(e)?Tt(e):Ot(e):[]}:Tt,Ht={args:"collection, callback, thisArg",top:"callback = callback && typeof thisArg == 'undefined' ? callback : baseCreateCallback(callback, thisArg, 3)",array:"typeof length == 'number'",keys:Rt,loop:"if (callback(iterable[index], index, collection) === false) return result"},Bt={args:"object, source, guard",top:"var args = arguments,\n    argsIndex = 0,\n    argsLength = typeof guard == 'number' ? 2 : args.length;\nwhile (++argsIndex < argsLength) {\n  iterable = args[argsIndex];\n  if (iterable && objectTypes[typeof iterable]) {",keys:Rt,loop:"if (typeof result[index] == 'undefined') result[index] = iterable[index]",bottom:"  }\n}"},Qt={top:"if (!objectTypes[typeof iterable]) return result;\n"+Ht.top,array:!1},Vt={"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#39;"},Wt=RegExp("["+Rt(Vt).join("")+"]","g"),Gt=d(Ht),Jt=d(Bt,{top:Bt.top.replace(";",";\nif (argsLength > 3 && typeof args[argsLength - 2] == 'function') {\n  var callback = baseCreateCallback(args[--argsLength - 1], args[argsLength--], 2);\n} else if (argsLength > 2 && typeof args[argsLength - 1] == 'function') {\n  callback = args[--argsLength];\n}"),loop:"result[index] = callback ? callback(result[index], iterable[index]) : iterable[index]"}),Kt=d(Bt),Mt=d(Ht,Qt,{useHas:!1}),Xt=d(Ht,Qt);x(/x/)&&(x=function(e){return"function"==typeof e&&wt.call(e)==ot}),a.assign=Jt,a.bind=q,a.createCallback=A,a.defaults=Kt,a.filter=P,a.forEach=$,a.forIn=Mt,a.forOwn=Xt,a.keys=Rt,a.property=L,a.reject=E,a.values=j,a.each=$,a.extend=Jt,a.select=P,a.clone=y,a.cloneDeep=C,a.escape=U,a.find=S,a.identity=O,a.isArguments=b,a.isArray=Ft,a.isFunction=x,a.isObject=w,a.isString=_,a.noop=D,a.template=I,a.detect=S,a.findWhere=S,a.VERSION="2.4.1",dt&&gt&&(vt?(gt.exports=a)._=a:dt._=a)}).call(this)}),require.register("side-comments/js/helpers/mobile-check.js",function(e,t,n){n.exports=function(){var e=!1;return function(t){(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(t)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(t.substr(0,4)))&&(e=!0)}(navigator.userAgent||navigator.vendor||window.opera),e}}),require.register("side-comments/templates/section.html",function(e,t,n){n.exports='<div class="side-comment <%= sectionClasses %>">\n  <a href="#" class="marker">\n    <span><%= comments.length %></span>\n  </a>\n  \n  <div class="comments-wrapper">\n    <ul class="comments">\n      <% _.each(comments, function( comment ){ %>\n        <%= _.template(commentTemplate, { comment: comment, currentUser: currentUser }) %>\n      <% }) %>\n    </ul>\n    \n    <a href="#" class="add-comment">Leave a comment</a>\n    \n    <% if (currentUser){ %>\n      <div class="comment-form">\n        <div class="author-avatar">\n          <img src="<%= currentUser.avatarUrl %>">\n        </div>\n        <p class="author-name">\n          <%= currentUser.name %>\n        </p>\n        <input type="text" class="comment-box right-of-avatar" placeholder="Leave a comment...">\n        <div class="actions right-of-avatar">\n          <a href="#" class="action-link post">Post</a>\n          <a href="#" class="action-link cancel">Cancel</a>\n        </div>\n      </div>\n    <% } %>\n  </div>\n</div>'}),require.register("side-comments/templates/comment.html",function(e,t,n){n.exports='<li data-comment-id="<%= comment.id %>">\n  <div class="author-avatar">\n    <img src="<%= comment.authorAvatarUrl %>">\n  </div>\n  <% if (comment.authorUrl) { %>\n    <a class="author-name right-of-avatar" href="<%= comment.authorUrl %>">\n      <%= comment.authorName %>\n    </a>\n  <% } else { %>\n    <p class="author-name right-of-avatar">\n      <%= comment.authorName %>\n    </p>\n  <% } %>\n  <p class="comment right-of-avatar">\n    <%= comment.comment %>\n  </p>\n  <% if (currentUser && comment.authorId === currentUser.id){ %>\n  <a href="#" class="action-link delete">Delete</a>\n  <% } %>\n</li>'}),require.alias("component-emitter/index.js","side-comments/deps/emitter/index.js"),require.alias("component-emitter/index.js","emitter/index.js"),require.alias("side-comments/js/main.js","side-comments/index.js");