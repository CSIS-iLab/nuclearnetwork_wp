document.addEventListener('DOMContentLoaded', function () {
  const defaultImage = document.querySelector('.default-featured-img')
  const featuredMediaFigure = document.querySelector('.featured-media')
  const entryHeaderContent = document.querySelector('.entry-header__content')
  const avatarDiv = document.querySelector('.archive__author-avatar')
  const defaultAvatarImage = document.querySelector('.avatar-default')

  if ((defaultImage !== null && featuredMediaFigure !== null) || (defaultImage !== null && entryHeaderContent !== null)) {
    featuredMediaFigure.style.display = 'none'
    entryHeaderContent.style.paddingBottom = '0'
  }

  if (defaultAvatarImage !== null && avatarDiv !== null) {
    avatarDiv.style.display = 'none'
  }

  console.log(defaultAvatarImage)
})
