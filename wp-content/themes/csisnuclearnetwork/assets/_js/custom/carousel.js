import Splide from '@splidejs/splide'

const elms = document.getElementsByClassName('js-splide')
for (let i = 0, len = elms.length; i < len; i++) {
  new Splide(elms[i], {
    type: 'loop',
    autoplay: true,
    cover: true,
    height: '8rem',
    keyboard: 'focused',
  }).mount()
}
