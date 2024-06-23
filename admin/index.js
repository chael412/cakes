let printBtn = document.querySelector('#print');
let saveBtn = document.querySelector('#save');

printBtn.addEventListener('click', function () {
	window.print();
});

saveBtn.addEventListener('click', function () {
	html2canvas(document.querySelector('#receipt_print')).then(function (canvas) {
		var link = document.querySelector('#receipt_print');
		link.setAttribute('download', 'mrsg_receipt.png');
		link.setAttribute('href', canvas.toDataURL('image/png').replace('image/png', 'image/octet-stream'));
		link.click();
	});
});
