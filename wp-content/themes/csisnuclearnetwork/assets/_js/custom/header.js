document.addEventListener('DOMContentLoaded', function () {
  const entryHeaderBlue = document.querySelector('.entry-header--blue')
  const entryHeaderLight = document.querySelector('.entry-header--light')
  const header = document.querySelector('.header')

  // Blue/Archive Header
  if (entryHeaderBlue !== null) {
    const pageHeaderHeight = `${(entryHeaderBlue.offsetHeight - 1) * -1}px`

    const entryHeaderOptions = {
      rootMargin: `${pageHeaderHeight} 0px 0px 0px`,
      threshold: 0,
    }

    const onIntersect = (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) {
          header.classList.add('full-color')
        } else {
          header.classList.remove('full-color')
        }
      })
    }

    const observer = new IntersectionObserver(onIntersect, entryHeaderOptions)

    observer.observe(entryHeaderBlue)
  }

  // Light/Single Post Header
  if (entryHeaderLight !== null) {
    const entryHeaderContent = entryHeaderLight.querySelector('.entry-header__content')
    const pageHeaderHeight = `${(entryHeaderContent.scrollHeight + header.offsetHeight) * -1}px`

    const entryHeaderOptions = {
      rootMargin: `${pageHeaderHeight} 0px 0px 0px`,
      threshold: 0,
    }

    const onIntersect = (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) {
          header.classList.add('full-color')
        } else {
          header.classList.remove('full-color')
        }
      })
    }

    const observer = new IntersectionObserver(onIntersect, entryHeaderOptions)

    observer.observe(entryHeaderContent)
  }

  // Homepage Header
  const homepage = document.querySelector('.home')
  const pageContent = document.querySelector('.home__top')
  const bigLogo = document.querySelector('.header__logo--home')

  if (homepage !== null) {
    const options = {
      rootMargin: '-102px 0px 0px 0px',
    }

    const onIntersect = (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) {
          header.classList.add('full-color')
          pageContent.classList.add('is-sticky')
        } else {
          header.classList.remove('full-color')
          pageContent.classList.remove('is-sticky')
        }
      })
    }

    const observer = new IntersectionObserver(onIntersect, options)

    observer.observe(bigLogo)
  }
})
