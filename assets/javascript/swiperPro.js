import Swiper from 'swiper';
import { Pagination, Autoplay } from 'swiper/modules';
import 'swiper/scss';
import 'swiper/scss/pagination';
const swiperArticle = new Swiper('.slider-programme', {
    modules: [Pagination, Autoplay],
    direction: 'horizontal',
    loop: true,
    autoplay: {
        delay: 3000,
        disableOnInteraction: true,
    },
    grabCursor: true,
    pagination: {
        el: '.swiper-pagination',
        type:'progressbar',
        clickable: true,
        
    },
});