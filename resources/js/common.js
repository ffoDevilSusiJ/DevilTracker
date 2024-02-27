
setTimeout(() => {
    let errors = document.querySelectorAll('.alert li');
    const showNextError = (index) => {
            if (index < errors.length) {
                errors[index].classList.add('fade-out'); 
                setTimeout(() => {
                    errors[index].remove(); 
                    setTimeout(() => { showNextError(index + 1); }, 5000)
                },3000)
            }
    };
    console.log(errors);
    if (errors.length > 0) {
        showNextError(0);
    }
},5000)


