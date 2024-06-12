document.addEventListener('DOMContentLoaded', function () {
    var container = document.getElementById('ad-units-container');
    var addButton = document.getElementById('add-ad-unit');
    var displaySlotIdCheckbox = document.getElementById('display_slot_id_enabled');

    function toggleSlotIdInputs() {
        var display = displaySlotIdCheckbox.checked ? 'block' : 'none';
        document.querySelectorAll('.slot-id-input').forEach(function(input) {
            input.style.display = display;
        });
    }
    displaySlotIdCheckbox.addEventListener('change', toggleSlotIdInputs);
    toggleSlotIdInputs();

    addButton.addEventListener('click', function () {
        var div = document.createElement('div');
        div.className = 'ad-unit';
        div.innerHTML = '<p></p>' + 
                        '<div>' +
                        '<input type="text" name="adsense_rotator_ad_units[]" value="" class="large-text mb-2" placeholder="Ad Unit ID" />' +
                        '<input type="text" name="adsense_rotator_slot_ids[]" value="" class="large-text slot-id-input mb-2" placeholder="Slot ID" style="display: ' + (displaySlotIdCheckbox.checked ? 'block' : 'none') + ';" />' +
                        '<button type="button" class="button remove-ad-unit">Remove</button>' +
                        '</div>';
        container.appendChild(div);
        updateCounter();
    });

    function updateCounter() {
        var units = container.querySelectorAll('.ad-unit');
        units.forEach(function(unit, index) {
            unit.querySelector('p').innerText = index + 1;
        });
    }

    container.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remove-ad-unit')) {
            e.target.parentElement.remove();
            updateCounter();
        }
    });
});


