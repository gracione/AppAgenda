let selecionar = (id)=>{
    let elementos = document.getElementsByClassName('s');

    for (let i = 0 ;i < elementos.length; i++) {
            elementos[i].style.background="white";
            document.getElementsByClassName(id)[0].style.background="red";          
            document.getElementsByClassName(id)[0].style.color="white";          
    }
}

console.log('dddd')