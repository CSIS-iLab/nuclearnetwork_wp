import Splide from '@splidejs/splide'

const elms = document.getElementsByClassName('js-splide')
for (let i = 0, len = elms.length; i < len; i++) {
  const splide = new Splide(elms[i], {
    type: 'loop',
    autoplay: true,
    keyboard: 'focused',
  }).mount()

  // Set the number of items to use in CSS calculations
  splide.root.style.setProperty('--num-items', splide.length)
}
