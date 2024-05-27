// document.querySelector('input[name="edit_comment2"]').addEventListener('click', function(event) {
//   event.preventDefault();
//   AreYouSure(event);
// });

function AreYouSure(event) {
  var commentText = document.getElementById("comment_text").value;
  if (commentText.trim() === "") {
    Swal.fire({
      title: 'Error!',
      text: 'Please enter a comment!',
      icon: 'error',
      confirmButtonText: 'OK'
    });
    return false;
  } 
}