document.addEventListener('DOMContentLoaded', function () {
  const entryHeader = document.querySelector('.entry-header')
  const header = document.querySelector('.header')

  if (entryHeader !== null) {
    const pageHeaderHeight = `${entryHeader.offsetHeight * -1}px`

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

    observer.observe(entryHeader)
  }

  const homepage = document.querySelector('.home')
  const border = document.querySelector('.home__top-border')

  const mobile = window.matchMedia('(max-width: 800px)')
  let siteHeaderHeight

  if (homepage !== null) {
    if (mobile.matches) {
      siteHeaderHeight = `${header.offsetHeight * -1 + 56}px`
    } else {
      siteHeaderHeight = `${header.offsetHeight * -1 + 102}px`
    }

    const options = {
      rootMargin: `${siteHeaderHeight} 0px 0px 0px`,
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

    const observer = new IntersectionObserver(onIntersect, options)

    observer.observe(border)
  }
})
