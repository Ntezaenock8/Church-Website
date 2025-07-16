document.querySelectorAll('.custom-dropdown').forEach(dropdown => {
    const selected = dropdown.querySelector('.dropdown-selected');
    const options = dropdown.querySelector('.dropdown-options');

    // Update selected value when an option is clicked
    dropdown.querySelectorAll('.option').forEach(option => {
        option.addEventListener('click', () => {
            selected.textContent = option.textContent;
            dropdown.dataset.value = option.dataset.value;
            options.style.display = 'none'; // Close dropdown after selection
            selected.setAttribute('aria-expanded', 'false');
        });
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', (event) => {
        if (!dropdown.contains(event.target)) {
            options.style.display = 'none';
            selected.setAttribute('aria-expanded', 'false');
        }
    });

    // Add keyboard accessibility
    selected.addEventListener('keydown', (event) => {
        if (event.key === 'Enter' || event.key === ' ') {
            options.style.display = options.style.display === 'block' ? 'none' : 'block';
            selected.setAttribute('aria-expanded', options.style.display === 'block');
        }
    });
});