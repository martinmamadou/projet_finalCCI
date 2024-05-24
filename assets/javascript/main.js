const burgerMenu = document.getElementById('burger-menu');

const overlay = document.getElementById('menu');

burgerMenu.addEventListener('click', function() {
  this.classList.toggle("close");
  overlay.classList.toggle("overlay");
});


const commentaire = document.querySelector('.commentaire')

const over = document.querySelector('.overlay')
const btnComment = document.querySelector('.comment')
console.log(commentaire)



btnComment.addEventListener('click', function(){
    commentaire.classList.remove('closed');
    over.classList.remove('closed');
})

let ex = document.querySelectorAll('.exList')
let front = document.querySelector('.exList-front')
let back = document.querySelector('.exList-back')

ex.forEach(elm => {
    elm.addEventListener('click', (e)=>{
        front=e.currentTarget.querySelector('.exList-front')
        back=e.currentTarget.querySelector('.exList-back')
        front.classList.toggle('flipped')
        back.classList.toggle('flipped')
    })
});



