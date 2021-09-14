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
        console.log(entry)
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

  if (homepage !== null) {
    const borderHeight = `${border.offsetHeight * -1}px`

    const options = {
      rootMargin: `${borderHeight} 0px 0px 0px`,
      threshold: 0,
    }

    const onIntersect = (entries) => {
      entries.forEach((entry) => {
        console.log(entry)
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
