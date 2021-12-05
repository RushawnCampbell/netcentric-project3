window.addEventListener("load", (event)=> {

    let inputFields = document.querySelectorAll(`input[type="text"]`);
    let pollstat = document.querySelector(`input[name="pollstat"]`);
    let c1votes = document.querySelector(`input[name="c1votes"]`);
    let c2votes = document.querySelector(`input[name="c2votes"]`);
    let reject = document.querySelector(`input[name="reject"]`);
    let totalv = document.querySelector(`input[name="totalv"]`);
    let submitbtn = document.querySelector("button#submitbtn");


    console.log(inputFields);

    submitbtn.addEventListener('click',(event) =>{
        // event.preventDefault();

        inputFields.forEach(inp => {
            inp.classList.remove("error");
            if (inp.value.length == 0){
                inp.style.background= "red";
            }
            if(  (/\D+/.test(inp.value) && inp.getAttribute("name") != "pollstat")) {
                inp.classList.add("error");
            }
        });

        if (/[^A-Z,0-9]+/g.test(pollstat.value) ) { 
            pollstat.classList.add("error");
        }

        if( (parseInt(c1votes.value)+ parseInt(c2votes.value) +parseInt(reject.value)) != parseInt(totalv.value) ){
            totalv.classList.add("error");
        }
    });
});