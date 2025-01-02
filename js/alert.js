// Include SweetAlert2 CDN in your header or as an npm package if using a bundler
// <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

// Function to show a success alert
function showSuccessAlert(title, message) {
  Swal.fire({
    icon: "success",
    title: title,
    text: message,
    showConfirmButton: false,
    timer: 2000,
  });
}

// Function to show an error alert
function showErrorAlert(title, message) {
  Swal.fire({
    icon: "error",
    title: title,
    text: message,
    showConfirmButton: true,
  });
}
