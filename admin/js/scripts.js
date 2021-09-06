$(function () {
	$("#summernote").summernote({
		height: 200,
	});
});

$(function () {
	$("#selectAllBoxes").on("click", function (e) {
		if (this.checked) {
			$(".checkBoxes").each(function () {
				this.checked = true;
			});
		} else {
			$(".checkBoxes").each(function () {
				this.checked = false;
			});
		}
	});
});

//Para activar loader en ADMIN
/* let div_box = "<div id='load-screen'><div id='loading'></div></div>";
$("body").prepend(div_box);

$("#load-screen")
	.delay(70)
	.fadeOut(60, function () {
		$(this).remove();
	});
 */
