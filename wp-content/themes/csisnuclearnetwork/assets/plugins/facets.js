;(function ($) {
  // const numFiltersApplied = document.querySelectorAll('.fp-num_filters_applied')

  let hasRun = false


  $(document).on('facetwp-loaded', function () {
    modifyFSelectFacet()
    modifySelectLabels()
    removeFSelectAtrributes()
    hasRun = true
  })


  function modifyFSelectFacet() {
    $('.facetwp-type-fselect').each(function () {
      const $facet = $(this)
      // console.log(FWP.settings)
      const facet_name = $facet.attr('data-name')
      const facet_label = FWP.settings.labels[facet_name]

      // Add Number of Selected Options to Wrapper
      const numSelected = FWP.facets[facet_name].length
      const noResults = document.querySelector('.no-results__heading')

      // Remove data attribute on no search results
      if (!noResults) {
        this.querySelector('.fs-label-wrap').setAttribute('data-num', numSelected)
      }

      // If these fields already exist, don't create them again.
      if (this.querySelector('.fs-label-field')) {
        return
      }

      // Add Facet Label
      const label = document.createElement('div')
      label.classList.add('fs-label-field')
      label.innerHTML = facet_label
      if (!hasRun) {
      const wrap = this.querySelector('.fs-label-wrap')
      // console.log(wrap)
      wrap.prepend(label) 
      wrap.classList.add('default-label')
      
      }
    })
  }

  function modifySelectLabels() {
    //   $(document).on('change', '.facetwp-dropdown', function () {
    //     const wrap = $('.fs-label-wrap')[0]
    //     const placeholder = $('.fs-label')[0] 
    //     console.log($('.fs-label-wrap'))

    //     if (placeholder.innerText === 'All Topics') {
    //       wrap.classList.add('default-label')
    //     } else {
    //       wrap.classList.remove('default-label')
    //     }
    //   }
    // )
      $(document).on('change', '.facetwp-dropdown', function () {

        $('.fs-label-wrap').each(function(index) {
          console.log(index)
          // if (index === 2) {
          const placeholder = $(this).children('.fs-label')
          const wrap = $(this)
          console.log(wrap[0].classList.remove('default-label'))
          if (placeholder[0].innerText === 'All Topics') {
                  // wrap[0].classList.add('default-label')
                } else {
                  wrap[0].classList.remove('default-label')
               }
          // }
        })
      }
    )
  }

  function removeFSelectAtrributes() {
      $('.facetwp-type-fselect').each(function () {
        const search = document.querySelectorAll('.fs-search')
        const checkBx = document.querySelectorAll('.fs-checkbox')
        // console.log(search)

        // Remove search and checkboxes from first two dropdowns
        for (let i = 0; i < 2; i++) {
          search[i].style.display = 'none';
          
        }

        for (let j = 0; j < checkBx.length; j++) {
          // console.log(j)
          const checkBx = document.querySelectorAll('.fs-checkbox')
          const topics = $('.facetwp-facet-topics')      
        }

      }
    )
  }
})(jQuery)