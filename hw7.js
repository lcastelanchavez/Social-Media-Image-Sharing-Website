
function do_ajax() {
    alert('in do_ajax'); 
    
    if( document.getElementById('img_title').value.length===0 || null) {
        alert("Error no image title!")
        exit;
    }

    if (document.getElementById('user_name_input').value.length ===0 || null) {
        alert("Error, no username input!")
        exit; 
    }

    const x = new XMLHttpRequest(); 
    x.onreadystatechange = function() {
        if(this.status ===200 && this.readyState ===4) {
            alert("done");
        }
    };
    
    x.open("PUT","upload.php",true); //send through PUT
    x.setRequestHeader("application-type","application/json"); 
    
     
    let name = document.getElementById("img_title").value;
    let user_name = document.getElementById("user_name_input").value;

    alert(name);
    alert(user_name); 

        const data_object = {
            image_title: name,
            user_name: user_name
            
        }; 
   
    x.send( "data_object="+JSON.stringify(data_object));

    window.location.href = "https://www.pic.ucla.edu/~lesliecastelan/HW7/upload.php"; 
      
}

function view() {
    /**
    if(document.getElementById('color'))
    const p = new XMLHttpRequest(); 
    p.onreadystatechange = function() {
        if(this.status ===200 && this.readyState ===4) {
            alert("done");
        }
    };
    
    p.open("PUT","display.php",true); //send through PUT
    p.setRequestHeader("application-type","application/json"); 
     */
    
    let colors = document.getElementsByName("color"); 
    let color = null; 
    for( let i=0; i<colors.length; i++) {
        if(colors[i].checked) {
            if(i===0) {
                color="red"; 
            }
            else {
                color="blue"; 
            }
        }
    }
    alert(color); 

    let person_to_view = document.getElementById('person_viewed_id').value; 

    alert(person_to_view); 

    const selection = {
        color_picked: color,            
        user_to_view: person_to_view
    }; 

    /**  
    p.send( "selection="+JSON.stringify(selection));
    */ 
   
}
 
document.getElementById('submit_button_upload').addEventListener("click", do_ajax);

document.getElementById('submit_button').addEventListener("click",view); 






