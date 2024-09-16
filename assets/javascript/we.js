function handleInputDisabling() {
    // Sélectionne tous les sous-formulaires
    const forms = document.querySelectorAll('.col-md-5');
  
    forms.forEach(form => {
      // Sélectionne tous les inputs à l'intérieur du sous-formulaire
      const inputs = form.querySelectorAll('input');
  
      if (inputs.length >= 2) {
        const champ1 = inputs[0];
        const champ2 = inputs[1];
  
        // Fonction pour mettre à jour l'état disabled des champs
        function updateInputs() {
          champ2.disabled = champ1.value.length > 0;
          champ1.disabled = champ2.value.length > 0;
        }
  
        // Ajoute les événements d'écoute pour les deux champs
        champ1.addEventListener('input', updateInputs);
        champ2.addEventListener('input', updateInputs);
  
        // Appelle la fonction une fois au début pour mettre à jour l'état initial
        updateInputs();
      }
    });
  }
  
  // Fonction pour ajouter un sous-formulaire à la collection
  function addFormToCollection(e) {
    e.preventDefault();
  
    // On stocke l'élément HTML (ul) en ciblant le bouton, puis son dataset, puis son nom de holder class
    const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);
  
    // On crée un nouvel élément li qui sera implémenté dans ul
    const item = document.createElement('li');
    item.classList.add('col-md-5');
  
    // Injecter HTML dans li, lui injecte le dataprototype du ul en modifiant le nom
    item.innerHTML = collectionHolder
      .dataset
      .prototype
      .replace(
        /__name__/g,
        collectionHolder.dataset.index
      );
  
    // Ajoute un bouton de suppression
    const btnRemove = document.createElement('button');
    btnRemove.setAttribute('type', 'button');
    btnRemove.classList.add('btn', 'btn-danger', 'text-light', 'btn-remove-collection');
    btnRemove.innerHTML = '<i class="bi bi-x-octagon-fill"></i>';
    item.prepend(btnRemove);
  
    // Ajoute item li dans le code ul
    collectionHolder.appendChild(item);
  
    // Écoute de l'événement sur clic du bouton pour activer la fonction remove
    btnRemove.addEventListener('click', removeCollectionForm);
  
    // Incrémente l'index pour chaque li
    collectionHolder.dataset.index++;
  
    // Re-vérifie les inputs pour les nouveaux sous-formulaires
    handleInputDisabling();
  }
  
  // Attache l'événement click à chaque bouton 'add_item_link' de manière unique
  document
    .querySelectorAll('.add_item_link')
    .forEach(btn => {
      // Vérifie que l'événement n'est pas déjà attaché
      if (!btn.dataset.eventAttached) {
        btn.addEventListener('click', addFormToCollection);
        btn.dataset.eventAttached = true; // Marque comme attaché
      }
    });
  
  // Attache les événements de suppression aux boutons existants
  document.querySelectorAll('.btn-remove-collection')
    .forEach(btnRemove => {
      btnRemove.addEventListener('click', removeCollectionForm);
    });
  
  // Initialise le contrôle des inputs sur les sous-formulaires existants
  handleInputDisabling();
  