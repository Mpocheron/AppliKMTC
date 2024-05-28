const toggler = document.querySelector(".hamburger");
const navLinksContainer = document.querySelector(".navlinks-container");

const toggleNav = e => {
  // Animation du bouton
  toggler.classList.toggle("open");

  const ariaToggle =
    toggler.getAttribute("aria-expanded") === "true" ? "false" : "true";
  toggler.setAttribute("aria-expanded", ariaToggle);

  // Slide de la navigation
  navLinksContainer.classList.toggle("open");
};

toggler.addEventListener("click", toggleNav);

const navLinks = document.querySelectorAll(".navlinks-container a");
navLinks.forEach(link => {
  link.addEventListener("click", function() {
    navLinksContainer.classList.remove("open");
    toggler.classList.remove("open");
    toggler.setAttribute("aria-expanded", "false");
  });
});

new ResizeObserver(entries => {
  if (entries[0].contentRect.width <= 900){
    navLinksContainer.style.transition = "transform 0.4s ease-out";
  } else {
    navLinksContainer.style.transition = "none";
  }
}).observe(document.body)

// document.addEventListener('DOMContentLoaded', function () {
//   const relaisField = document.getElementById('relais');
//   const adresseDestinationField = document.getElementById('adresse-destination');

//   function toggleDestinationField() {
//       if (relaisField.value) {
//           adresseDestinationField.style.display = 'none';
//       } else {
//           adresseDestinationField.style.display = 'block';
//       }
//   }

//   relaisField.addEventListener('change', toggleDestinationField);
//   toggleDestinationField(); // Initial call
// });
// document.addEventListener('DOMContentLoaded', function () {
//         const relaisField = document.querySelector('[name="commande[relais]"]');
//         const adresseDestinationField = document.querySelector('.choix-destination');

//         function toggleAdresseDestination() {
//             if (relaisField.value) {
//                 adresseDestinationField.style.display = 'none';
//             } else {
//                 adresseDestinationField.style.display = 'block';
//             }
//         }

//         relaisField.addEventListener('change', toggleAdresseDestination);
//         toggleAdresseDestination(); // Appeler une fois au chargement pour cacher si nécessaire
    // });

  //   document.addEventListener('DOMContentLoaded', function() {
  //     const toggler = document.querySelector(".hamburger");
  //     const navLinksContainer = document.querySelector(".navlinks-container");
  
  //     const toggleNav = () => {
  //         // Animation du bouton
  //         toggler.classList.toggle("open");
  
  //         const ariaToggle = toggler.getAttribute("aria-expanded") === "true" ? "false" : "true";
  //         toggler.setAttribute("aria-expanded", ariaToggle);
  
  //         // Slide de la navigation
  //         navLinksContainer.classList.toggle("open");
  //     };
  
  //     toggler.addEventListener("click", toggleNav);
  
  //     const navLinks = document.querySelectorAll(".navlinks-container a");
  //     navLinks.forEach(link => {
  //         link.addEventListener("click", function() {
  //             navLinksContainer.classList.remove("open");
  //             toggler.classList.remove("open");
  //             toggler.setAttribute("aria-expanded", "false");
  //         });
  //     });
  
  //     new ResizeObserver(entries => {
  //         if (entries[0].contentRect.width <= 900) {
  //             navLinksContainer.style.transition = "transform 0.4s ease-out";
  //         } else {
  //             navLinksContainer.style.transition = "none";
  //         }
  //     }).observe(document.body);
  // });
  
  // document.addEventListener('DOMContentLoaded', function() {
  //     const billingCheckbox = document.getElementById('useUserBillingAddress');
  //     const shippingCheckbox = document.getElementById('useUserShippingAddress');
  
  //     const billingFields = {
  //         numero: document.getElementById('adresseFacturationNumero'),
  //         nom: document.getElementById('adresseFacturationNom'),
  //         codePostal: document.getElementById('adresseFacturationCodePostal'),
  //         ville: document.getElementById('adresseFacturationVille')
  //     };
  
  //     const shippingFields = {
  //         numero: document.getElementById('adresseExpeditionNumero'),
  //         nom: document.getElementById('adresseExpeditionNom'),
  //         codePostal: document.getElementById('adresseExpeditionCodePostal'),
  //         ville: document.getElementById('adresseExpeditionVille')
  //     };
  
  //     const userAddress = {
  //         numero: document.getElementById('adresseUserNumero').value,
  //         nom: document.getElementById('adresseUserNom').value,
  //         codePostal: document.getElementById('adresseUserCodePostal').value,
  //         ville: document.getElementById('adresseUserVille').value
  //     };
  
  //     function fillAddressFields(fields, userAddress) {
  //         fields.numero.value = userAddress.numero;
  //         fields.nom.value = userAddress.nom;
  //         fields.codePostal.value = userAddress.codePostal;
  //         fields.ville.value = userAddress.ville;
  //     }
  
  //     billingCheckbox.addEventListener('change', function() {
  //         if (this.checked) {
  //             fillAddressFields(billingFields, userAddress);
  //         } else {
  //             fillAddressFields(billingFields, { numero: '', nom: '', codePostal: '', ville: '' });
  //         }
  //     });
  
  //     shippingCheckbox.addEventListener('change', function() {
  //         if (this.checked) {
  //             fillAddressFields(shippingFields, userAddress);
  //         } else {
  //             fillAddressFields(shippingFields, { numero: '', nom: '', codePostal: '', ville: '' });
  //         }
  //     });
  // });
  // Identifier les boutons et les champs d'adresse dans le DOM
const useUserBillingAddressButton = document.getElementById('useUserBillingAddressButton');
const useUserShippingAddressButton = document.getElementById('useUserShippingAddressButton');
const adresseFacturationField = document.getElementById('commandeform_adresseFacturation');
const adresseExpeditionField = document.getElementById('commandeform_adresseExpedition');

// Ajouter des écouteurs d'événements aux boutons
useUserBillingAddressButton.addEventListener('click', () => {
    // Remplir les champs d'adresse avec les informations de l'utilisateur
    adresseFacturationField.value = '{{ app.user.adresseUser.numero }} {{ app.user.adresseUser.nom }}, {{ app.user.adresseUser.codePostal }} {{ app.user.adresseUser.ville }}';
});

useUserShippingAddressButton.addEventListener('click', () => {
    // Remplir les champs d'adresse avec les informations de l'utilisateur
    adresseExpeditionField.value = '{{ app.user.adresseUser.numero }} {{ app.user.adresseUser.nom }}, {{ app.user.adresseUser.codePostal }} {{ app.user.adresseUser.ville }}';
});

  