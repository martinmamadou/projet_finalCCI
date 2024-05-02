const burgerMenu = document.getElementById('burger-menu');

const overlay = document.getElementById('menu');

burgerMenu.addEventListener('click', function() {
  this.classList.toggle("close");
  overlay.classList.toggle("overlay");
});


const commentaire = document.querySelector('.commentaire')
const btnComment = document.querySelector('.comment')
console.log(commentaire)



btnComment.addEventListener('click', function(){
    commentaire.classList.remove('closed');
})