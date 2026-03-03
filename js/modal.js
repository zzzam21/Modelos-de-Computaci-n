const modal = document.getElementById("addTeamModal");
const open = document.getElementById("openModal");
const close = document.getElementById("closeModal");

open.addEventListener('click', () => modal.showModal());
close.addEventListener('click', () => modal.close());

const editModal = document.getElementById("editTeamModal");
const closeEdit = document.getElementById("closeEditModal");

closeEdit.addEventListener('click', () => editModal.close());
