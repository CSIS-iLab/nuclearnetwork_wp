;(function ($) {
  // const numFiltersApplied = document.querySelectorAll('.fp-num_filters_applied')

  let hasRun = false


  $(document).on('facetwp-loaded', function () {
    modifyFSelectFacet()
    modifySelectLabels()
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

      const wrap = this.querySelector('.fs-label-wrap')
      wrap.prepend(label) 
      wrap.classList.add('default-label')
    })
  }

  function modifySelectLabels() {
      $(document).on('change', '.facetwp-dropdown', function () {
        const wrap = $('.fs-label-wrap')[0]
        const placeholder = $('.fs-label')[0] 

        if (placeholder.innerText === 'All Topics') {
          wrap.classList.add('default-label')
        } else {
          wrap.classList.remove('default-label')
        }
      }
    )
  }
})(jQuery)