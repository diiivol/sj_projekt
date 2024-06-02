window.addEventListener('DOMContentLoaded', (event) => {
    document.querySelectorAll('.edit-button').forEach((button) => {
        button.addEventListener('click', (event) => {
            event.preventDefault();
            let row = event.target.closest('tr');
            let nameField = row.querySelector('.dish-name');
            let descriptionField = row.querySelector('.dish-description');
            let priceField = row.querySelector('.dish-price');
            let ingredientsField = row.querySelector('.dish-ingredients');
            let imageField = row.querySelector('.dish-image');
            let form = event.target.closest('form');
            let nameInput = form.querySelector('input[name="new_dish_name"]');
            let descriptionInput = form.querySelector('input[name="new_dish_description"]');
            let priceInput = form.querySelector('input[name="new_dish_price"]');
            let ingredientsInput = form.querySelector('input[name="new_dish_ingredients"]');
            let imageSelect = form.querySelector('select[name="new_dish_image"]');
            nameField.textContent = '';
            descriptionField.textContent = '';
            priceField.textContent = '';
            ingredientsField.textContent = '';
            imageField.innerHTML = '';
            let editableNameInput = document.createElement('input');
            editableNameInput.type = 'text';
            editableNameInput.value = nameInput.value;
            editableNameInput.style.width = '100%';
            editableNameInput.addEventListener('input', (event) => {
                nameInput.value = event.target.value;
            });
            let editableDescriptionInput = document.createElement('textarea');
            editableDescriptionInput.rows = 4;
            // editableDescriptionInput.cols = 60;
            editableDescriptionInput.style.width = '100%';
            editableDescriptionInput.value = descriptionInput.value;
            editableDescriptionInput.addEventListener('input', (event) => {
                descriptionInput.value = event.target.value;
            });
            let editablePriceInput = document.createElement('input');
            editablePriceInput.type = 'number';
            editablePriceInput.min = 0;
            editablePriceInput.step = 0.50;
            editablePriceInput.value = priceInput.value;
            editablePriceInput.style.width = '100%';
            editablePriceInput.addEventListener('input', (event) => {
                priceInput.value = event.target.value;
            });
            let editableIngredientsInput = document.createElement('textarea');
            editableIngredientsInput.rows = 4;
            editableIngredientsInput.style.width = '100%';
            editableIngredientsInput.value = ingredientsInput.value;
            editableIngredientsInput.addEventListener('input', (event) => {
                ingredientsInput.value = event.target.value;
            });

            // Create a new select element for the image
            let editableImageSelect = document.createElement('select');
            // Copy the options from the original select to the new one
            for (let option of imageSelect.options) {
                let newOption = document.createElement('option');
                newOption.value = option.value;
                newOption.text = option.text;
                newOption.selected = option.selected;
                editableImageSelect.add(newOption);
            }
            // When the new select changes, update the original one
            editableImageSelect.addEventListener('change', (event) => {
                imageSelect.value = event.target.value;
            });

            nameField.appendChild(editableNameInput);
            descriptionField.appendChild(editableDescriptionInput);
            priceField.appendChild(editablePriceInput);
            ingredientsField.appendChild(editableIngredientsInput);
            imageField.appendChild(editableImageSelect);
            event.currentTarget.style.display = 'none';
            row.querySelector('.save-button').style.display = 'inline';
        });
    });
});