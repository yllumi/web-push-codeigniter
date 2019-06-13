'use strict';

let publicKey = localStorage.getItem('publicKey');
let privateKey = localStorage.getItem('privateKey');
updateVapidForm();
if(publicKey === null) generateVapid();

function generateVapid(){
  fetch(site_url+'/push/vapid')
  .then(function(response){
    if (response.status !== 200) {
      console.log('Failed to get vapid keys. Status Code: ' + response.status);
      return;
    }

    response.json()
    .then(function(data){
      publicKey = data.publicKey
      privateKey = data.privateKey

      localStorage.setItem('publicKey', publicKey)
      localStorage.setItem('privateKey', privateKey)

      updateVapidForm()
    })
  })
  .catch(function(err) {
    console.log('Fetch Error :-S', err);
  });
}

function updateVapidForm()
{
  document.getElementById('publickey').value = publicKey
  document.getElementById('privatekey').value = privateKey
}

document.getElementById('regenerate').addEventListener('click', function(){
  generateVapid();
})


let btnSend = document.getElementById('send')
btnSend.addEventListener('click', function(){
  btnSend.innerHTML = 'Mengirim..'
  btnSend.disabled = true

  let payload = document.getElementById('payload').value
  let subscription = document.getElementById('subscription').value
  if(subscription === "") alert('subscription JSON harus diisi')

  let data = {
    publicKey: publicKey,
    privateKey: privateKey,
    subscription: subscription,
    payload: payload
  }

  let strData = JSON.stringify(data)

  fetch(site_url+'/push/send', {
    method: 'POST',
    body: strData,
    headers:{
      'Content-Type': 'application/json'
    }
  })
  .then(function(response){
    if(response.status !== 200){
      console.log(response)
      alert('Failed to get response from server. Status Code: ' + response.status)
      btnSend.innerHTML = 'Kirim Payload'
      btnSend.disabled = false
      return;
    }

    return response.json()
  })
  .then(function(json){
    console.log(json)
    document.getElementById('result').innerHTML = JSON.stringify(json)
    btnSend.innerHTML = 'Kirim Payload'
    btnSend.disabled = false
  })
  .catch(error => console.error('Error:', error))

})