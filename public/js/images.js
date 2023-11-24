alert("salut");

const addFormToCollection = (e) => {
  const collectionPhoto = document.querySelector(
    e.currentTarget.dataset.collection
  );
  console.log(collectionPhoto);
  const item = document.createElement("div");
  console.log(item);
  item.className = "mt-3";
  item.innerHTML = collectionPhoto.dataset.prototype.replace(
    /__name__/g,
    collectionPhoto.dataset.index
  );
  let btnSupprimer = document.createElement("button");
  btnSupprimer.className = "btn btn-info mt-3 btn-supprimmer";
  btnSupprimer.innerHTML = "supprimer l'image";
  item.appendChild(btnSupprimer);
  document.querySelectorAll(".btnSupprimer").forEach((btn) =>
    btn.addEventListener("click", () => {
      e.currentTarget.parentElement.remove();
    })
  );
};

document
  .querySelectorAll(".btn-ajouter")
  .forEach((btn) => btn.addEventListener("click", addFormToCOllection));
