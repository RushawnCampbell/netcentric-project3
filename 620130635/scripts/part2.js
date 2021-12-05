
function validate(){
    let data_set = [
        document.form.clerkID.value,
        document.form.constID.value,
        document.form.pdID.value,
        document.form.pollStation.value,
        document.form.c1votes.value,
        document.form.c2votes.value,
        document.form.rejected.value,
        document.form.total.value,
    ];

    let fill_status = false;
    let int_status = false;
    const isEmpty = (ele) => ele.length > 0;
    const isInt = (ele) => Number.isInteger(ele);  

    fill_status =  data_set.every(isEmpty);
      
    if(fill_status){ // check if all fields contain data
        let polling = data_set.splice(3,1);
        regex = /^[a-z0-9]+$/i;
        data_set = data_set.map(el =>parseInt(el));
        console.log(data_set);
        console.log(data_set[6]);

        if(regex.exec(polling[[0]])){ // check against pattern
            int_status = data_set.every(isInt); // check if rest of elements are int
            if(int_status){ // check fot totality
                if(data_set[6] ==(data_set[5] + data_set[4] + data_set[3]) ){
                    console.log('valid');
                    return true;
                }
                else{console.log('total invalid');}
            }
            else{
                console.log('failed Int status');
                return false;
            }
        }
        else{
            console.log('pattern check failed');
            return false;
        }        
    }

    console.log("a field is empty");
    return false;
}