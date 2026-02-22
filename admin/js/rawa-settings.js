(function ($) {
	const $select   = $( "#rawa_aos_disable" );
	const $tableRow = $( ".form-table tbody tr:nth-child(6)" );
	function updateVisibility() {
		const value = $select.val();
		$tableRow.toggle( value === "custom" );
	}
	updateVisibility();
	$select.on( "change", updateVisibility );
	$( document ).on( "ajaxStop widget-added widget-updated", updateVisibility );
})( jQuery );
