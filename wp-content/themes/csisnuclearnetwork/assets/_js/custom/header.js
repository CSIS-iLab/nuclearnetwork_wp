document.addEventListener('DOMContentLoaded', function () {
  const entryHeader = document.querySelector('.entry-header')
  const header = document.querySelector('.header')

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
})
