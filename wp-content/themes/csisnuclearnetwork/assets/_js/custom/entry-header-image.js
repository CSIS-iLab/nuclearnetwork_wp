const defaultImage = document.querySelector('.default-featured-img')
const featuredMediaFigure = document.querySelector('.featured-media')
const entryHeaderContent = document.querySelector('.entry-header__content')

if (defaultImage !== null) {
  console.log(defaultImage)
  featuredMediaFigure.style.display = 'none'
  entryHeaderContent.style.paddingBottom = '0'
}
