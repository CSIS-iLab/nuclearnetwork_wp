;(function ($) {
  // const numFiltersApplied = document.querySelectorAll('.fp-num_filters_applied')

  let hasRun = false


  $(document).on('facetwp-loaded', function () {
    modifyFSelectFacet()
    // modifySelectLabels()
    // removeFSelectAtrributes()
    modifyCheckboxes()
    hasRun = true
  })


  function modifyFSelectFacet() {
    $('.facetwp-type-fselect').each(function () {
      const $facet = $(this)
      const facet_name = $facet.attr('data-name')
      const facet_label = FWP.settings.labels[facet_name]

      // Add Number of Selected Options to Wrapper
      const numSelected = FWP.facets[facet_name].length
      const noResults = document.querySelector('.no-results__heading')

      // Remove data attribute on no search results
      if (!noResults) {
        this.querySelector('.fs-label-wrap').setAttribute('data-num', numSelected)
      }
    })
  }

  function modifyCheckboxes() {
    $('.facetwp-checkbox').each(function () {
      const checkbox = this.querySelector('.fs-checkbox')
      if (checkbox) {
        return
      }

      const span = document.createElement('span')
      span.classList.add('fs-checkbox')
      span.innerHTML = '<i></i>'

      this.prepend(span)
    })
  }
})(jQuery)