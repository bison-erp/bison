<script type="text/javascript">
	function numberFormat(number, decimals, dec_point, thousands_sep)
	{
		number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
		var n = !isFinite(+number) ? 0 : +number,
			prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
			sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
			dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
			s = '',
			toFixedFix = function (n, prec)
			{
				var k = Math.pow(10, prec);
				return '' + Math.round(n * k) / k;
			};
		// Fix for IE parseFloat(0.55).toFixed(0) = 0;
		s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
		if (s[0].length > 3)
		{
			s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
		}
		if ((s[1] || '').length < prec)
		{
			s[1] = s[1] || '';
			s[1] += new Array(prec - s[1].length + 1).join('0');
		}
		return s.join(dec);
	}

	function  format_currency_javascript(amount,currency_symbol)
	{
	   
		var nb_decimal = $('#tax_rate_decimal_places').val();
		var currency_symbol_placement = $('#currency_symbol_placement').val();
		var thousands_separator = $('#thousands_separator').val();
		var decimal_point = $('#decimal_point').val();
		
		
		
		
		if (currency_symbol_placement == 'before') {
			return currency_symbol + numberFormat(amount, nb_decimal, decimal_point, thousands_separator);
		} else {
			return numberFormat(amount, nb_decimal, decimal_point, thousands_separator) + currency_symbol;
		}
	}

</script>