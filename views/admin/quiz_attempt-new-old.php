<?php 
$this->load->view('admin/layout/header.php');
$this->load->view('admin/layout/menu_admin.php');
?>
 <style>
 td{
		font-size:14px;
		padding:4px;
	}
	
	
</style>


<script>

var Timer;
var TotalSeconds;


function CreateTimer(TimerID, Time) {
Timer = document.getElementById(TimerID);
TotalSeconds = Time;

UpdateTimer()
window.setTimeout("Tick()", 1000);
}

function Tick() {
if (TotalSeconds <= 0) {
alert("Time's up!")
return;
}

TotalSeconds -= 1;
UpdateTimer()
window.setTimeout("Tick()", 1000);
}

function UpdateTimer() {
var Seconds = TotalSeconds;

var Days = Math.floor(Seconds / 86400);
Seconds -= Days * 86400;

var Hours = Math.floor(Seconds / 3600);
Seconds -= Hours * (3600);

var Minutes = Math.floor(Seconds / 60);
Seconds -= Minutes * (60);


var TimeStr = ((Days > 0) ? Days + " days " : "") + LeadingZero(Hours) + ":" + LeadingZero(Minutes) + ":" + LeadingZero(Seconds)


Timer.innerHTML = TimeStr;
}


function LeadingZero(Time) {

return (Time < 10) ? "0" + Time : + Time;

}

//var myCountdown1 = new Countdown({time:<?php echo $seconds;?>, rangeHi:"hour", rangeLo:"second"});
setTimeout(submitform,'<?php echo $seconds * 1000;?>');
function submitform(){
alert('Time Over');
window.location="<?php echo site_url('quiz/submit_quiz/');?>";
}

 

 

</script>



<div class="container" style="margin-top: 15px;" >

    <form action="results_random.php" method="post">
        <?php
//        echo '<pre>';
//        print_r($questions);
//        echo '<pre>';
//        echo '<pre>';
//        print_r($options);
//        echo '<pre>';die;
//        $list_question = '<table>';
        $i=1;
        $k = 0;
        $m = 0;
        $n = count($questions);
        $list_question = array();
//        $list_question_xxx = '<table>';
//        $i=0;
        foreach ($questions as $question_key =>$question_value){
            $list_question[$k] =$question_value['question'].' <br><br> &nbsp;&nbsp;&nbsp;&nbsp;';
//            $list_question_xxx .=$question_value['question'].' <br><br> &nbsp;&nbsp;&nbsp;&nbsp;';
            foreach ($options as $options_key => $options_value){
                if($question_value['qid']==$options_value['qid']){
//                    if($m==0)$list_question_xxx .='<tr><td>';
//                    $m++;
                    $list_question[$k] .='<br/>'.'<input type="radio" name="q'.$i.'" value="'.$options_value['q_option'].'"> '.$options_value['q_option'].'<br>&nbsp;&nbsp;&nbsp;&nbsp;';
//                    $list_question_xxx .='<br/>'.'<input type="radio" name="q'.$i.'" value="'.$options_value['q_option'].'"> '.$options_value['q_option'].'<br>&nbsp;&nbsp;&nbsp;&nbsp;';
//                    $i++;
////                    if($m==count())
                }
//             $list_question_xxx .='<tr><td>'.'<input type="radio" name="q'.$i.'" value="'.$options_value['q_option'].'"> '.$options_value['q_option'].'<br>&nbsp;&nbsp;&nbsp;&nbsp;';
             
//                $m=0;
//                $list_question_xxx .='</td></tr>';
                
            }
//            $list_question_xxx .='</table>';
            $k++;
//                   echo $list_question_xxx;die;
            
//            echo $question_value['question'];
        }
//         echo '<pre>';
//        print_r($list_question);
//        echo '</pre>';
        echo '<table><tbody>';
        foreach ($list_question as $key){
            echo '<Br/>';
            echo '<tr><td>'.$key.'<br><br> &nbsp;&nbsp;&nbsp;&nbsp;</td></tr>';
                    
        }
        echo '</table></tbody>';
        
//        var_dump($list_question);
//        $rand_keys = array_rand($list_question, $n);
//        echo '<table><tr><td>';
//        echo "1.&nbsp;&nbsp;". $list_question[$rand_keys[0]] . "<br>";
//        for($t=1;$t<$n;$t++){
//            echo "</td></tr><tr><td>";
//            echo "1.&nbsp;&nbsp;". $list_question[$rand_keys[$t]] . "<br>";
//            echo '<p></p>';
//        }
//        echo "</td></tr></table>";
        echo '<table><tbody><tr><td>
            1.&nbsp;&nbsp;What are the two binary numbers?<br><br> &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="q1" value="1 and O"> 1 and O<br>&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="q1" value="2 and 0"> 2 and O<br>&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="q1" value="1 to 9"> 1 to 9<p></p><br></td></tr><tr><td>
            2.&nbsp;&nbsp;It is a standard specifying a power saving feature.<br><br>&nbsp;&nbsp;&nbsp;&nbsp; 
            <input type="radio" name="q2" value="PnP"> PnP<br>&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="q2" value="ACPI"> ACPI<br>&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="q2" value="BIOS"> BIOS<p></p><br></td></tr><tr><td>
            19.&nbsp;&nbsp;Software designed for hardware related task.<br><br>&nbsp;&nbsp;&nbsp;&nbsp; 
            <input type="radio" name="q24" value="Hardware"> Hardware<br>&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="q24" value="Application Software">Application Software<br>&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="q24" value="System Software"> System Software<br>&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="q24" value="RAM"> RAM<p></p><br></td></tr><tr><td>20.&nbsp;&nbsp;What do you call the group of microchips controlling data flow?<br><br>
            &nbsp;&nbsp;&nbsp;&nbsp; answer: &nbsp;&nbsp;&nbsp;&nbsp;  
            <input type="text" name="answer4"><p></p><br></td></tr></tbody></table>';
        
//        echo "<center>". "<br><table><tr><td>";
//
//echo "1.&nbsp;&nbsp;". $links[$rand_keys[0]] . "<br>";
//echo "</td></tr><tr><td>";
        $links=array('What are the two binary numbers?<br><br> &nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q1" value="1 and O"> 1 and O<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q1" value="2 and 0"> 2 and O<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q1" value="1 to 9"> 1 to 9</p>', 
               
			    'It is a standard specifying a power saving feature.<br><br>&nbsp;&nbsp;&nbsp;&nbsp; 
						<input type="radio" name="q2" value="PnP"> PnP<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q2" value="ACPI"> ACPI<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q2" value="BIOS"> BIOS</p>',
               
			    'A part of a computer processor that carries out computation.<br><br>&nbsp;&nbsp;&nbsp;&nbsp; 
						<input type="radio" name="q3" value="CU"> CU<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q3" value="CPU"> CPU<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q3" value="ALU"> ALU<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q3" value="RAM"> RAM</p>', 
              
			    'An output which is a printed one.<br><br>&nbsp;&nbsp;&nbsp;&nbsp; 
						<input type="radio" name="q4" value="CLEAR COPY"> CLEAR COPY<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q4" value="HARDCOPY">HARDCOPY<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q4" value="SOFTCOPY"> SOFTCOPY<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q4" value="PHOTOCOPY"> PHOTOCOPY</p>',
			
				'A continous and additive process and simplifies quantitative changes<br><br>
						&nbsp;&nbsp;&nbsp;&nbsp; answer: &nbsp;&nbsp;&nbsp;&nbsp;  
						<input type="text" name="answer" ></p>',
						
				'The speed of computer is measured by.<br><br>&nbsp;&nbsp;&nbsp;&nbsp; 
						<input type="radio" name="q5" value="bit"> bit<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q5" value="byte"> byte<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q5" value="hertz"> hertz</p>',
						
				'Operating system that was first introduced in 1984 with Macintosh Computer.<br><br>&nbsp;&nbsp;&nbsp;&nbsp; 
						<input type="radio" name="q6" value="OS/2"> OS/2<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q6" value="Mac OS"> Mac OS<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q6" value="UNIX"> UNIX</p>',
						
				'The first operating system used by IBM computers.<br><br>&nbsp;&nbsp;&nbsp;&nbsp; 
						<input type="radio" name="q7" value="DOS"> DOS<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q7" value="Windows 9x/Me"> Windows 9x/Me<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q7" value="Linux"> Linux</p>',
						
				'It is a component of operating system that exposes function to user and applications.<br><br>&nbsp;&nbsp;&nbsp;&nbsp; 
						<input type="radio" name="q8" value="Shell"> Shell<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q8" value="Kernel"> Kernel<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q8" value="Shell and Kernel"> Shell and Kernel</p>',
						
				'It is a primary graphical interface to operating system. <br><br>&nbsp;&nbsp;&nbsp;&nbsp; 
						<input type="radio" name="q9" value="Windows Explorer"> Windows Explorer<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q9" value="Windows Desktop"> Windows Desktop<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q9" value="Windows Help"> Windows Help</p>',
						
				'Most important electrical component of computer is: <br><br>&nbsp;&nbsp;&nbsp;&nbsp; 
						<input type="radio" name="q10" value="Operating System"> Operating System<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q10" value="Power Supply"> Power Supply<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q10" value="Application Software"> Application Software</p>',
						
				'It visually displays primary-output of computer.<br><br>
						&nbsp;&nbsp;&nbsp;&nbsp; answer: &nbsp;&nbsp;&nbsp;&nbsp;  
						<input type="text" name="answer2" ></p>',
				
				'What does TCP stands for?<br><br>
						&nbsp;&nbsp;&nbsp;&nbsp; answer: &nbsp;&nbsp;&nbsp;&nbsp;  
						<input type="text" name="answer3" ></p>',
						
						
						
						
				'It provides a way to perform task without a mouse. <br><br>&nbsp;&nbsp;&nbsp;&nbsp; 
						<input type="radio" name="q13" value="Key Stroke Short Cuts"> Key Stroke Short Cuts<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q13" value="Device Manager"> Device Manager<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q13" value="System Information"> System Information</p>',
						
				'Refers to Windows 95, Windows 98, Windows Me and designed to bridge legacy and newer technologies <br><br>&nbsp;&nbsp;&nbsp;&nbsp; 
						<input type="radio" name="q14" value="Windows NT"> Windows NT<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q14" value="DOS"> DOS<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q14" value="Windows 9x/Me"> Windows 9x/Me</p>',
						
				'What is the code name of Windows Vista?<br><br>&nbsp;&nbsp;&nbsp;&nbsp; 
						<input type="radio" name="q15" value="Long Horn"> Long Horn<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q15" value="Short Horn"> Short Horn<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q15" value="Middle Horn"> Middle Horn</p>',
						
				'Device providing temporary storage.<br><br>&nbsp;&nbsp;&nbsp;&nbsp; 
						<input type="radio" name="q16" value="ROM"> ROM<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q16" value="RAM"> RAM<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q16" value="RIMM"> RIMM</p>',
						
				'An access point located in back or front of case. <br><br>&nbsp;&nbsp;&nbsp;&nbsp; 
						<input type="radio" name="q17" value="port">port<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q17" value="mouse"> mouse<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q17" value="keyboard"> keyboard</p>',
					
				
				'One MegaHertz is equivalent to?<br><br>&nbsp;&nbsp;&nbsp;&nbsp; 
						<input type="radio" name="q18" value="1 Billion cycle/second"> 1 Billion cycle/second<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q18" value="100 cycle/second"> 100 cycle/second<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q18" value="1 million cycle/second"> 1 million cycle/second</p>',
						
				'What is the range of CPU speed?<br><br>&nbsp;&nbsp;&nbsp;&nbsp; 
						<input type="radio" name="q19" value="166 MHz to 4 GHz"> 166 MHz to 4 GHz<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q19" value="166 GHz to 4 MHz"> 166 GHz to 4 MHz<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q19" value="167 MHz to 4 GHz"> 167 MHz to 4 GHz</p>',
						
				'It enables secondary storage device to interface with the motherboard. <br><br>&nbsp;&nbsp;&nbsp;&nbsp; 
						<input type="radio" name="q20" value="ROM">ROM<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q20" value="Computer"> Computer<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q20" value="Parallel and Serial ATA Standard"> Parallel and Serial ATA Standard</p>',							
						
			    'An output which can be seen in the screen.<br><br>&nbsp;&nbsp;&nbsp;&nbsp; 
						<input type="radio" name="q21" value="CLEAR COPY"> CLEAR COPY<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q21" value="HARDCOPY">HARDCOPY<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q21" value="SOFTCOPY"> SOFTCOPY<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q21" value="PHOTOCOPY"> PHOTOCOPY</p>',
						
				'Smallest unit of data in a computer system.<br><br>&nbsp;&nbsp;&nbsp;&nbsp; 
						<input type="radio" name="q22" value="BYTE"> BYTE<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q22" value="KILOBYTE">KILOBYTE<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q22" value="MEGABYTE"> MEGABYTE<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q22" value="BIT"> BIT</p>',
						
				'Part of main memory where it stores data temporarirly.<br><br>&nbsp;&nbsp;&nbsp;&nbsp; 
						<input type="radio" name="q23" value="ROM"> ROM<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q23" value="FLOPPY DISK">FLOPPY DISK<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q23" value="RAM"> RAM<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q23" value="HARD DISK"> HARD DISK</p>',
						
				'Software designed for hardware related task.<br><br>&nbsp;&nbsp;&nbsp;&nbsp; 
						<input type="radio" name="q24" value="Hardware"> Hardware<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q24" value="Application Software">Application Software<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q24" value="System Software"> System Software<br>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="q24" value="RAM"> RAM</p>',
						
				'What do you call the group of microchips controlling data flow?<br><br>
						&nbsp;&nbsp;&nbsp;&nbsp; answer: &nbsp;&nbsp;&nbsp;&nbsp;  
						<input type="text" name="answer4" ></p>'
            ); 
        
        
        ?>
    </form>
</div>



<?php $this->load->view('admin/layout/footer.php');?>