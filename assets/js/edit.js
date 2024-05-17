window.addEventListener('DOMContentLoaded', (event) => {
    document.querySelectorAll('.edit-button').forEach((button) => {
        button.addEventListener('click', (event) => {
            event.preventDefault();

            let row = event.target.closest('tr');
            let nameField = row.querySelector('.dish-name');
            let descriptionField = row.querySelector('.dish-description');
            let form = event.target.closest('form');
            let nameInput = form.querySelector('input[name="new_dish_name"]');
            let descriptionInput = form.querySelector('input[name="new_dish_description"]');

            nameField.textContent = '';
            descriptionField.textContent = '';

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

            nameField.appendChild(editableNameInput);
            descriptionField.appendChild(editableDescriptionInput);

            event.target.style.display = 'none';
            row.querySelector('.save-button').style.display = 'inline';
        });
    });
});