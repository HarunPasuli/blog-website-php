// Get the share link and modal elements
const shareLink = document.getElementById("share-link");
const shareModal = document.getElementById("share-modal");

// Get the input field, copy button, and sharing links inside the modal
const shareUrl = document.getElementById("share-url");
const copyBtn = document.getElementById("copy-btn");
const facebookLink = shareModal.querySelector('a[href*="facebook.com"]');
const twitterLink = shareModal.querySelector('a[href*="twitter.com"]');

// Add a click event listener to the share link
shareLink.addEventListener("click", function(event) {
  event.preventDefault(); // Prevent the link from navigating to a new page
  // Set the current URL as the value of the input field
  shareUrl.value = window.location.href;
  // Update the Facebook and Twitter links with the current URL
  facebookLink.href = `http://www.facebook.com/sharer.php?u==${encodeURIComponent(window.location.href)}`;
  twitterLink.href = `https://twitter.com/intent/tweet?url=${encodeURIComponent(window.location.href)}`;
  // linkedInLink.href = `http://www.linkedin.com/shareArticle?mini=true&url=${encodeURIComponent(window.location.href)}`;
  // Show the modal
  shareModal.style.display = "block";
});

// Add a click event listener to the copy button
copyBtn.addEventListener("click", function() {
  // Select the input field
  shareUrl.select();
  shareUrl.setSelectionRange(0, 99999); // For mobile devices

  // Copy the text inside the input field to the clipboard
  document.execCommand("copy");

  // Close the modal
  shareModal.style.display = "none";
});

// Add a click event listener to the modal overlay to close the modal
shareModal.addEventListener("click", function(event) {
  if (event.target === shareModal) {
    shareModal.style.display = "none";
  }
});

// Add a keydown event listener to the document to close the modal with the Escape key
document.addEventListener("keydown", function(event) {
  if (event.key === "Escape") {
    shareModal.style.display = "none";
  }
});