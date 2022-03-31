const btnBar=document.querySelectorAll(".classes__item");
const contenu=document.querySelectorAll(".contenu");

btnBar.forEach(item => {
    item.addEventListener("click",(e)=>{
        display(e.target.id);
    }
    );
    
});

function display(id){
    contenu.forEach(item =>{
        item.classList.add("hidden");
        if(id == item.getAttribute("class-id"))
            {
                item.classList.remove("hidden");
            }
        else
        {
            item.classList.add("hidden");
        }
             
      
    })
}

function ajouter(){
  
    const btn1=document.querySelector("#btn1");
    const btnInput=document.querySelector(".fontFamily");


   console.log(btnInput);


}