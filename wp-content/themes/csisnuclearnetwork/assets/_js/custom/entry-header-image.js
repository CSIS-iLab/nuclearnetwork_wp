document.addEventListener('DOMContentLoaded', function () {
  const defaultImage = document.querySelector('.default-featured-img')
  const featuredMediaFigure = document.querySelector('.featured-media')
  const entryHeaderContent = document.querySelector('.entry-header__content')

  if ((defaultImage !== null && featuredMediaFigure !== null) || (defaultImage !== null && entryHeaderContent !== null)) {
    featuredMediaFigure.style.display = 'none'
    entryHeaderContent.style.paddingBottom = '0'
  }
})
