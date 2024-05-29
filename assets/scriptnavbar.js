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


//   document.addEventListener('DOMContentLoaded', function() {
//     // Utiliser les éléments de formulaire et les cases à cocher
//     const billingCheckbox = document.getElementById('useUserBillingAddress');
//     const shippingCheckbox = document.getElementById('useUserShippingAddress');
    
//     const billingFields = {
//         numero: document.querySelector('[name="commande[adresseFacturation][numero]"]'),
//         nom: document.querySelector('[name="commande[adresseFacturation][nom]"]'),
//         codePostal: document.querySelector('[name="commande[adresseFacturation][codePostal]"]'),
//         ville: document.querySelector('[name="commande[adresseFacturation][ville]"]')
//     };

//     const shippingFields = {
//         numero: document.querySelector('[name="commande[adresseExpedition][numero]"]'),
//         nom: document.querySelector('[name="commande[adresseExpedition][nom]"]'),
//         codePostal: document.querySelector('[name="commande[adresseExpedition][codePostal]"]'),
//         ville: document.querySelector('[name="commande[adresseExpedition][ville]"]')
//     };

//     // Obtenez les informations de l'utilisateur à partir de Twig et assurez-vous qu'elles sont correctement échappées
//     const userAddress = {
//         numero: "{{ app.user.adresseUser.numero|e('js') }}",
//         nom: "{{ app.user.adresseUser.nom|e('js') }}",
//         codePostal: "{{ app.user.adresseUser.codePostal|e('js') }}",
//         ville: "{{ app.user.adresseUser.ville|e('js') }}"
//     };

//     // Fonction pour pré-remplir les champs avec les données utilisateur
//     function fillAddressFields(fields, userAddress) {
//         fields.numero.value = userAddress.numero;
//         fields.nom.value = userAddress.nom;
//         fields.codePostal.value = userAddress.codePostal;
//         fields.ville.value = userAddress.ville;
//     }

//     // Gestion des événements des cases à cocher
//     billingCheckbox.addEventListener('change', function() {
//         if (this.checked) {
//             fillAddressFields(billingFields, userAddress);
//         } else {
//             // Clear the fields if unchecked
//             fillAddressFields(billingFields, { numero: '', nom: '', codePostal: '', ville: '' });
//         }
//     });

//     shippingCheckbox.addEventListener('change', function() {
//         if (this.checked) {
//             fillAddressFields(shippingFields, userAddress);
//         } else {
//             // Clear the fields if unchecked
//             fillAddressFields(shippingFields, { numero: '', nom: '', codePostal: '', ville: '' });
//         }
//     });
// });
// document.addEventListener('DOMContentLoaded', function() {
//     // Utiliser les éléments de formulaire et les cases à cocher
//     const billingCheckbox = document.getElementById('useUserBillingAddress');
//     const shippingCheckbox = document.getElementById('useUserShippingAddress');
    
//     const billingFields = {
//         numero: document.querySelector('[name="commande[adresseFacturation][numero]"]'),
//         nom: document.querySelector('[name="commande[adresseFacturation][nom]"]'),
//         codePostal: document.querySelector('[name="commande[adresseFacturation][codePostal]"]'),
//         ville: document.querySelector('[name="commande[adresseFacturation][ville]"]')
//     };
//     console.log("Données billingFields récupérées :", billingFields);
//     const shippingFields = {
//         numero: document.querySelector('[name="commande[adresseExpedition][numero]"]'),
//         nom: document.querySelector('[name="commande[adresseExpedition][nom]"]'),
//         codePostal: document.querySelector('[name="commande[adresseExpedition][codePostal]"]'),
//         ville: document.querySelector('[name="commande[adresseExpedition][ville]"]')
//     };
//     console.log("Données shippingFields récupérées :", shippingFields);
//     // Obtenez les informations de l'utilisateur à partir de Twig et assurez-vous qu'elles sont correctement échappées
//     const userAddress = {
//         numero: decodeURIComponent("{{ app.user.adresseUser.numero }}"),
//         nom: decodeURIComponent("{{ app.user.adresseUser.nom }}"),
//         codePostal: decodeURIComponent("{{ app.user.adresseUser.codePostal }}"),
//         ville: decodeURIComponent("{{ app.user.adresseUser.ville }}")
//     };
//     console.log("Données utilisateur récupérées :", userAddress);

//     // Fonction pour pré-remplir les champs avec les données utilisateur
//     function fillAddressFields(fields, userAddress) {
//         fields.numero.value = userAddress.numero;
//         fields.nom.value = userAddress.nom;
//         fields.codePostal.value = userAddress.codePostal;
//         fields.ville.value = userAddress.ville;
//     }

//     // Gestion des événements des cases à cocher
//     billingCheckbox.addEventListener('change', function() {
//         if (this.checked) {
//             fillAddressFields(billingFields, userAddress);
//         } else {
//             // Clear the fields if unchecked
//             fillAddressFields(billingFields, { numero: '', nom: '', codePostal: '', ville: '' });
//         }
//     });

//     shippingCheckbox.addEventListener('change', function() {
//         if (this.checked) {
//             fillAddressFields(shippingFields, userAddress);
//         } else {
//             // Clear the fields if unchecked
//             fillAddressFields(shippingFields, { numero: '', nom: '', codePostal: '', ville: '' });
//         }
//     });
// });
document.addEventListener('DOMContentLoaded', function() {
  const billingCheckbox = document.getElementById('useUserBillingAddress');

  billingCheckbox.addEventListener('change', function() {
      const numero = this.dataset.numero;
      const nom = this.dataset.nom;
      const codePostal = this.dataset.codePostal;
      const ville = this.dataset.ville;

      console.log("Données de la case à cocher de facturation :", numero, nom, codePostal, ville);

      // Utilisez ces données pour remplir les champs du formulaire d'adresse de facturation
      const numeroField = document.querySelector('[name="commande[adresseFacturation][numero]"]');
      const nomField = document.querySelector('[name="commande[adresseFacturation][nom]"]');
      const codePostalField = document.querySelector('[name="commande[adresseFacturation][codePostal]"]');
      const villeField = document.querySelector('[name="commande[adresseFacturation][ville]"]');

      numeroField.value = numero;
      nomField.value = nom;
      codePostalField.value = codePostal;
      villeField.value = ville;
  });

  const shippingCheckbox = document.getElementById('useUserShippingAddress');

  shippingCheckbox.addEventListener('change', function() {
      const numero = this.dataset.numero;
      const nom = this.dataset.nom;
      const codePostal = this.dataset.codePostal;
      const ville = this.dataset.ville;

      // Utilisez ces données pour remplir les champs du formulaire d'adresse d'expédition
      const numeroField = document.querySelector('[name="commande[adresseExpedition][numero]"]');
      const nomField = document.querySelector('[name="commande[adresseExpedition][nom]"]');
      const codePostalField = document.querySelector('[name="commande[adresseExpedition][codePostal]"]');
      const villeField = document.querySelector('[name="commande[adresseExpedition][ville]"]');

      numeroField.value = numero;
      nomField.value = nom;
      codePostalField.value = codePostal;
      villeField.value = ville;
  });
});
