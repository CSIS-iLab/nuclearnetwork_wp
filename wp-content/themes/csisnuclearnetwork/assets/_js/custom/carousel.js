import Splide from '@splidejs/splide'
// new Splide('#splide').mount()

const elms = document.getElementsByClassName('splide')
for (let i = 0, len = elms.length; i < len; i++) {
  new Splide(elms[i]).mount()
}
