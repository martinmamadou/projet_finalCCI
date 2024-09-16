const footer = document.querySelector('footer')
const nav = document.querySelector('nav')
window.addEventListener('scroll',function(){
const y = footer.getBoundingClientRect().top + window.scrollY ;
const x = nav.getBoundingClientRect().top + window.scrollY ;
console.log(x,y)
if(x >= y){
    nav.classList.add('hidden')
} else {
    nav.classList.remove('hidden')
}
})
const commentaire = document.querySelector('.commentaire')
const over = document.querySelector('.overlay')
const btnComment = document.querySelector('.comment')
console.log(commentaire)
btnComment.addEventListener('click', function(){
    commentaire.classList.remove('closed');
    over.classList.remove('closed');
})




