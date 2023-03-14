        var tim;       

        function customSubmit(someValue){  
			document.getElementsByName("hours").value = hrs; 
        	 document.getElementsByName("minute").value = min;   
        	 document.getElementsByName("second").value = sec; 
        	//  document.questionForm.submit(); 
				quizOver(); 
        	}  

        function examTimer() {
            if (parseInt(sec) >0) {

			    document.getElementById("timer").innerHTML = "Time Left:"+hrs+":" +min+":"+sec;
                sec = parseInt(sec) - 1;                
                tim = setTimeout("examTimer()", 1000);
            }
            else {
			    if (parseInt(hrs)==0 && parseInt(min)==0 && parseInt(sec)==0){
			    	document.getElementById("timer").innerHTML = "Time Left:"+hrs+":" +min+":"+sec;
					document.getElementsByName("hours").value=0;
				     document.getElementsByName("minute").value=0;
				     document.getElementsByName("second").value=0;
        
					quizOver();
			     }

				 if (parseInt(hrs)>0 &&parseInt(sec) == 0 && parseInt(min) == 0 ) {				
				    document.getElementById("timer").innerHTML = "Time Left:"+hrs+":" +min+":"+sec;					
                    hrs = parseInt(hrs) - 1;
					min = 59;
					sec=59;
                    tim = setTimeout("examTimer()", 1000);
                }
                if (parseInt(sec) == 0 && parseInt(min) > 0) {				
				    document.getElementById("timer").innerHTML = "Time Left:"+hrs+":" +min+":"+sec;					
                    min = parseInt(min) - 1;
					sec=59;
                    tim = setTimeout("examTimer()", 1000);
                }

            }
        }