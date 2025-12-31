

// Update Badges
function updateBadges(id){
	const tombol = document.getElementById(`tombolUpdateBadge${id}`)
	const forms = document.getElementById('menuFormBadges')
	forms.setAttribute('action',forms.getAttribute('update'))

	const idBadges = tombol.getAttribute('data-id')
	const nameBadge = tombol.getAttribute('data-name')
	const html = `
		<input type="hidden" name="id_badge" id="badgeId" value="${idBadges}" readonly />
	`
	let html2 = `
		<input type="hidden" name="_method" value="PUT" id="put" />
	`
	forms.querySelector('#badgeName').value = nameBadge
	let select = forms.querySelector('#badgeId')
	let select2 = forms.querySelector('#put')
	if (select && select2) {
		select.value = idBadges
	}else{
		forms.insertAdjacentHTML('afterbegin',html)
		forms.insertAdjacentHTML('afterbegin',html2)
	}
}

// Reset Form Badges
function reseFormsBadgeUpdate(){
	const forms = document.getElementById('menuFormBadges')
	let select = forms.querySelector('#badgeId')
	let select2 = forms.querySelector('#put')
	forms.setAttribute('action',forms.getAttribute('create'))

	if (select2) {
		select2.remove();
	}

	if (select) {
		select.remove();
	}
}


// Update Sub
function updateMenuSub(id){
	const forms = document.getElementById('menuFormSub')
	forms.setAttribute('action',forms.getAttribute('update'))

	const tombol = document.getElementById(`tombolUpdateSub${id}`)

	const html = `
		<input type="hidden" name="id_sub" id="subId" value="${id}" readonly />
	`
	let html2 = `
		<input type="hidden" name="_method" value="PUT" id="put" />
	`

	let select  = forms.querySelector('#subId')
	let select2 = forms.querySelector('#put')
	if (select && select2) {
		select.value = id
	}else{
		forms.insertAdjacentHTML('afterbegin',html)
		forms.insertAdjacentHTML('afterbegin',html2)
	}

	forms.querySelector('#nameSub').value = tombol.getAttribute('data-name')
	forms.querySelector('#badgeSub').value = tombol.getAttribute('data-badge')
	forms.querySelector('#iconSub').value = tombol.getAttribute('data-icon')
}

function resetFormsSubUpdate(){
	const forms = document.getElementById('menuFormSub')
	forms.setAttribute('action',forms.getAttribute('create'))

	let select = forms.querySelector('#subId')
	let select2 = forms.querySelector('#put')

	if (select2) {
		select2.remove();
	}

	if (select) {
		select.remove();
	}

	forms.querySelector('#nameSub').value = ''
	forms.querySelector('#badgeSub').value = ''
	forms.querySelector('#iconSub').value = ''
}

function deleteSub(id){
	const forms = document.getElementById('formDeleteSub')
	const html = `
		<input type="hidden" name="id_sub" id="subId" value="${id}" readonly />
	`
	let select = forms.querySelector('#subId')

	if (select) {
		select.value = id
	}else{
		forms.insertAdjacentHTML('afterbegin',html)
	}
	forms.submit()
}

function deleteBadge(id){
	const forms = document.getElementById('formDeleteBadge')
	const html = `
		<input type="hidden" name="id_badge" id="badgeId" value="${id}" readonly />
	`
	let select = forms.querySelector('#badgeId')

	if (select) {
		select.value = id
	}else{
		forms.insertAdjacentHTML('afterbegin',html)
	}
	forms.submit()
}

const modalUpdateMenu = document.getElementById("updateMenuModal");
modalUpdateMenu.addEventListener("show.bs.modal", function (event) {
  const button = event.relatedTarget; // button that opened modal
  const name = button.getAttribute("data-name");
  const id = button.getAttribute('data-id')
  const sub = button.getAttribute('data-sub')
  const role = button.getAttribute('data-role')
  const url = button.getAttribute('data-url')

  modalUpdateMenu.querySelector("#nameMenu").value = name ?? null
  modalUpdateMenu.querySelector('#idMenu').value = id ?? null
  modalUpdateMenu.querySelector('#roleMenu').value = role ?? null
  modalUpdateMenu.querySelector('#subMenu').value = sub ?? null
  modalUpdateMenu.querySelector('#urlMenu').value = url ?? null
});

const modalDeleteMenu = document.getElementById("deleteMenuModal");
modalDeleteMenu.addEventListener("show.bs.modal", function (event) {
  const button = event.relatedTarget; // button that opened modal
  const id = button.getAttribute('data-id')
  console.log(id)
  modalDeleteMenu.querySelector('#menuId').value = id

})