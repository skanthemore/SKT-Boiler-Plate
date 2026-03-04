document.addEventListener('DOMContentLoaded', function () {
	const rows = document.querySelectorAll('[data-key="field_project_media"] .acf-row');

	rows.forEach(function (row) {
		const aspectField = row.querySelector('[data-key="field_aspect_ratio"] input[type="radio"]:checked');
		const cropField = row.querySelector('[data-key="field_cropped_image"]');

		if (aspectField && cropField) {
			const val = aspectField.value;
			// Injectar attribute 'data-aspect-ratio' a la imatge crop
			cropField.setAttribute('data-aspect-ratio', val);
		}

		// Si l’usuari canvia el ratio...
		row.querySelectorAll('[data-key="field_aspect_ratio"] input[type="radio"]').forEach(function (radio) {
			radio.addEventListener('change', function () {
				const ratio = this.value;
				const crop = row.querySelector('[data-key="field_cropped_image"]');
				if (crop) {
					crop.setAttribute('data-aspect-ratio', ratio);
				}
			});
		});
	});
});
