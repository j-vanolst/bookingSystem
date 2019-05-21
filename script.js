function deleteChild(childID) {
  $.post('ajax.php', {type: 'delete', childID: childID}, function(data) {
    location.reload()
  })
}

function editChild(childID) {
  $(`form#child${childID} :input`).each(function() {
    if ($(this).attr('disabled')) {
      $(this).removeAttr('disabled')
    }
  })
  $(`form#child${childID} :button`).each(function() {
    $(this).removeClass('hidden')
  })
}

function saveChild(childID) {
  let inputs = [childID]
  $(`form#child${childID} :input`).each(function() {
    inputs.push($(this).val())
  })
  $.post('ajax.php', {type: 'edit', childID: inputs[0], firstName: inputs[1], lastName: inputs[2], birthdate: inputs[3], gender: inputs[4], allergies: inputs[5]}, function(data) {
    location.reload()
  })
}
