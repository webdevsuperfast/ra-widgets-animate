(function ($) {
	const $select   = $( "#rawa_aos_disable" );
	const $tableRow = $( ".form-table tbody tr:nth-child(6)" );

	function updateVisibility() {
		const value = $select.val();
		$tableRow.toggle( value === "custom" );
	}

	// Initial state
	updateVisibility();

	// Bind change event once
	$select.on( "change", updateVisibility );

	// Re-check on dynamic updates
	$( document ).on( "ajaxStop widget-added widget-updated", updateVisibility );
})( jQuery );
