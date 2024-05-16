window.addEventListener('DOMContentLoaded', (event) => {
    document.querySelectorAll('.edit-button').forEach((button) => {
        button.addEventListener('click', (event) => {
            event.preventDefault();

            let form = event.target.closest('form');
            let nameField = form.querySelector('.name-field');
            let descriptionField = form.querySelector('.description-field');

            let nameInput = document.createElement('input');
            nameInput.type = 'text';
            nameInput.name = 'new_dish_name';
            nameInput.value = nameField.textContent;

            let descriptionInput = document.createElement('input');
            descriptionInput.type = 'text';
            descriptionInput.name = 'new_dish_description';
            descriptionInput.value = descriptionField.textContent;

            nameField.replaceWith(nameInput);
            descriptionField.replaceWith(descriptionInput);

            event.target.style.display = 'none';
            form.querySelector('.save-button').style.display = 'block';
        });
    });
});