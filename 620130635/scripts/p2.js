function validate() {
    let data = {
        clerkID: (document.form.clerkID.value),
        constID: (document.form.constID.value),
        pdID: (document.form.pdID.value),
        pollStation: document.form.pollStation.value,
        c1votes: (document.form.c1votes.value),
        c2votes: (document.form.c2votes.value),
        rejected: (document.form.rejected.value),
        total: (document.form.total.value),
        hiddenField: document.form.hiddenField.value
    };
    

   /* if (noEmptyFields(data)) && areIntegers(data) && alphaNum(data['pollStation']) && valSum(data['c1votes'],data['c2votes'],data['rejected'],data['total']){
        console.log('true');
    }*/
    
    let a = noEmptyFields(data);    
    let b =areIntegers(data);    
    let c = alphaNum(data['pollStation']);
    let d = valSum(data['c1votes'],data['c2votes'],data['rejected'],data['total']);
    
    if(!a||!b||!c||!d){        
        return false;
    }
    
    return true;
        
}


function noEmptyFields(fields){
    let r = true;
    for(let x in fields){        
        if(fields[x] == ''){
            r = false;
            document.getElementById(x).classList.add('eerror');
        }else{
            document.getElementById(x).classList.remove('eerror');
        }
            
    }    
    return r;
}

function areIntegers(fields){    
   let d = {...fields};
   delete d.pollStation;
   delete d.hiddenField;     
   let r = true;
   
   for(let x in d){    
       if(!Number.isInteger(Number(d[x]))){       
        document.getElementById(x).classList.add('ierror');
        r = false;                
       } else {
        document.getElementById(x).classList.remove('ierror');
       }
   }
   return r;
   
    /* return Number.isInteger(fields["clerkID"]) && Number.isInteger(fields["constID"]) && Number.isInteger(fields["pdID"])
        && Number.isInteger(fields["c1votes"]) && Number.isInteger(fields["c2votes"]) && Number.isInteger(fields["rejected"])
        && Number.isInteger(fields["total"]) && Number.isInteger(fields["pdID"]) &&
        Number.isInteger(fields["rejected"])*/
}

function alphaNum(ps) {    
    if (ps !== "" && ps.match(/^[a-zA-Z0-9]*$/)) {
        document.getElementById('pollStation').classList.remove('aerror');
    } else {        
        document.getElementById('pollStation').classList.add('aerror');
        return false;
    }
    return true;
}

function valSum(c1,c2,r,t){
    /*console.log(c1);
    console.log(c2);
    console.log(r);
    console.log(t);*/
    if (Number(t) !== Number(c1)+Number(c2)+Number(r)) {
        document.getElementById('total').classList.add('terror');
        document.getElementById('c1votes').classList.add('terror');
        document.getElementById('c2votes').classList.add('terror');
        document.getElementById('rejected').classList.add('terror');
        return false;
    } else {
        document.getElementById('total').classList.remove('terror');
        document.getElementById('c1votes').classList.remove('terror');
        document.getElementById('c2votes').classList.remove('terror');
        document.getElementById('rejected').classList.remove('terror');
    }
    return true;

}