window.addEventListener('DOMContentLoaded', (event) => {
    document.querySelectorAll('.edit-button').forEach((button) => {
        button.addEventListener('click', (event) => {
            event.preventDefault();

            let row = event.target.closest('tr');
            let nameField = row.querySelector('.dish-name');
            let descriptionField = row.querySelector('.dish-description');
            let priceField = row.querySelector('.dish-price');
            let ingredientsField = row.querySelector('.dish-ingredients');
            let form = event.target.closest('form');
            let nameInput = form.querySelector('input[name="new_dish_name"]');
            let descriptionInput = form.querySelector('input[name="new_dish_description"]');
            let priceInput = form.querySelector('input[name="new_dish_price"]');
            let ingredientsInput = form.querySelector('input[name="new_dish_ingredients"]');

            nameField.textContent = '';
            descriptionField.textContent = '';
            priceField.textContent = '';
            ingredientsField.textContent = '';

            let editableNameInput = document.createElement('input');
            editableNameInput.type = 'text';
            editableNameInput.value = nameInput.value;
            editableNameInput.addEventListener('input', (event) => {
                nameInput.value = event.target.value;
            });

            let editableDescriptionInput = document.createElement('input');
            editableDescriptionInput.type = 'text';
            editableDescriptionInput.value = descriptionInput.value;
            editableDescriptionInput.addEventListener('input', (event) => {
                descriptionInput.value = event.target.value;
            });

            let editablePriceInput = document.createElement('input');
            editablePriceInput.type = 'text';
            editablePriceInput.value = priceInput.value;
            editablePriceInput.addEventListener('input', (event) => {
                priceInput.value = event.target.value;
            });

            let editableIngredientsInput = document.createElement('input');
            editableIngredientsInput.type = 'text';
            editableIngredientsInput.value = ingredientsInput.value;
            editableIngredientsInput.addEventListener('input', (event) => {
                ingredientsInput.value = event.target.value;
            });

            nameField.appendChild(editableNameInput);
            descriptionField.appendChild(editableDescriptionInput);
            priceField.appendChild(editablePriceInput);
            ingredientsField.appendChild(editableIngredientsInput);

            event.target.style.display = 'none';
            row.querySelector('.save-button').style.display = 'inline';
        });
    });
});