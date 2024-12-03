@extends('layouts.admincaisse')

@section('title')

Caisse vente direct
    
@endsection

@section('content')

<div class="main-body">
    <div class="page-wrapper">
            <!-- Fenêtre modale -->
    <div id="modal" class="modal">
        <span class="close-button">&times;</span>
        <h5>Liste des clients</h5>
        <table border="1" width="100%">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Adresse</th>
                    <th>Téléphone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="clientTable">
                <!-- Les lignes seront générées dynamiquement -->
            </tbody>
        </table>
        <h>Ajouter un nouveau client</h5>
    <form id="addClientForm">
        <div>
            <label for="clientName">Nom :</label>
            <input type="text" id="clientName" name="name" required>
        </div>
        <div>
            <label for="clientAddress">Adresse :</label>
            <input type="text" id="clientAddress" name="address" required>
        </div>
        <div>
            <label for="clientPhone">Téléphone :</label>
            <input type="text" id="clientPhone" name="phone" required>
        </div>
        <button type="submit">Ajouter et Commander</button>
    </form>
 
    </div>

    <!-- Overlay (arrière-plan gris) -->
    <div id="overlay" class="overlay"></div>

        <div class="page-body">
          <div class="row">
                        <!-- card1 start -->
                        
                        <!-- card1 end -->
                        <!-- Statestics Start -->
              <div class="col-md-12 col-xl-8">
                    <div class="card">
                        <div class="card-header">
                        <!-- Produits au centre -->
                            <div id="product-list">
                              <div class="row" id="products">
                                    <!-- Produits seront affichés ici dynamiquement -->
                              </div>
                            </div>                                                        
                          </div>
                      </div>
                </div>



                <div class="col-md-12 col-xl-4">
                    <div class="card fb-card">
                          <div class="card-header">
                                        
                                <div class="d-inline-block">
                                    <div class="card-block text-center">
                                        <button class="btn btn-out-dotted btn-info btn-square" onclick="validatePurchase()">Vente direct</button>
                                        <button class="btn btn-out-dotted btn-danger btn-square" id="listeCommande">Commandes</button>
                                    </div>
                                    <!-- ------------ Ticket table -------------- -->
                                    <table class="table table-ticket" id="table">
                                        <thead>
                                            <tr>
                                                <th class="lib">Libelle</th>
                                                <th class="lib">Prix</th>
                                                <th class="lib">Quantite</th>
                                                <th class="lib">Total</th>
                                                <th class="deleteIcon">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="ticket-body" class="ticket-body">
                                            <!-- Lignes de commande ajoutées ici -->
                                        </tbody>
                                    </table>
                                    
                                <div id="total-container">
                                    <p class="total">Total : <span id="total-amount">0.00 Ar</span></p>
                                </div>
                                </div>
                                

                              <div class="card-block text-center">
                                  <button class="btn btn-primary btn-outline-primary" onclick="validatePurchase()">Valider</button>
                                  <button class="btn btn-primary btn-outline-primary" id="openModalButton">Commander</button>
                              </div>
                        </div>
                      </div>
                  </div>
          </div>
      </div>
</div>
</div>


    
@endsection

@section('script')

<script>
    let productsData = {}; // Stocker les données des produits
    let cartItems = []; // Stocker les produits ajoutés au panier
    let uniqueKeyCounter = 1; // Compteur pour attribuer un identifiant unique aux articles

    async function fetchProducts() {
        try {
            const response = await fetch('http://gestion-de-caisse.test/api/admin/products/grouped');
            if (!response.ok) throw new Error('Erreur lors du chargement des produits');
            productsData = await response.json();
            console.log('Données des produits chargées:', productsData);
        } catch (error) {
            console.error('Erreur:', error);
        }
    }

    function loadProducts(category) {
        const products = productsData[category];
        const productsContainer = document.getElementById('products');
        productsContainer.innerHTML = '';

        if (products && Array.isArray(products)) {
            products.forEach((product) => {
                const productDiv = document.createElement('div');
                productDiv.className = 'col-md-3';
                const priceToDisplay = product.sub_unit_price !== undefined ? parseFloat(product.sub_unit_price) : parseFloat(product.main_unit_price);
                productDiv.innerHTML = `
                    <button class="btn btn-success btn-outline-success" onclick="selectProduct(${product.id}, '${product.name}', ${priceToDisplay})">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">${product.name}</h5>
                                <p class="card-text">Prix: $${priceToDisplay}</p>
                            </div>
                        </div>
                    </button>
                `;
                productsContainer.appendChild(productDiv);
            });
        } else {
            productsContainer.innerHTML = '<p>Aucun produit trouvé pour cette catégorie.</p>';
        }
    }

    function selectProduct(id, name, price) {
        const ticketBody = document.getElementById('ticket-body');
        const row = document.createElement('tr');
        
        const validPrice = price && !isNaN(price) ? parseFloat(price) : 0;
        const uniqueKey = uniqueKeyCounter++; // Assignation de l'identifiant unique
        
        cartItems.push({
            uniqueKey: uniqueKey,
            product_id: id,
            name: name,
            price: validPrice,
            quantity: 1,
            subtotal: validPrice
        });

        row.innerHTML = `
            <td class="lib">${name}</td>
            <td class="lib">${validPrice}</td>
            <td class="lib"><input type="number" value="1" min="1" style="width: 50px;" onchange="updateTotal(this, ${validPrice}, ${uniqueKey})"></td>
            <td class="lib"><span class="total-price">${validPrice.toFixed(2)}</span></td>
            <td><button class="deleteIcon" onclick="removeRow(this, ${uniqueKey})">❌</button></td>
        `;

        ticketBody.appendChild(row);
        updateTotalAmount();
    }

    function updateTotal(input, main_unit_price, uniqueKey) {
        const quantity = parseInt(input.value, 10);
        const totalCell = input.parentElement.nextElementSibling.querySelector('.total-price');
        const totalPrice = main_unit_price * quantity;

        totalCell.textContent = totalPrice.toFixed(2);
        
        const item = cartItems.find(item => item.uniqueKey === uniqueKey);
        if (item) {
            item.quantity = quantity;
            item.subtotal = totalPrice;
        }
        updateTotalAmount();
    }

    function removeRow(button, uniqueKey) {
        const row = button.closest('tr');
        row.remove();

        cartItems = cartItems.filter(item => item.uniqueKey !== uniqueKey);

        console.log(cartItems); // Vérification des données après suppression
        updateTotalAmount();
    }

    function updateTotalAmount() {
        const totalAmount = cartItems.reduce((total, item) => total + item.subtotal, 0);
        const totalElement = document.getElementById('total-amount');
        totalElement.textContent = `Ar ${totalAmount.toFixed(2)}`;
    }

    async function validatePurchase() {
    if (cartItems.length === 0) {
        alert("Le panier est vide !");
        return;
    }

    const totalAmount = cartItems.reduce((acc, item) => acc + item.subtotal, 0);

    // Utiliser toISOString() pour obtenir un format ISO 8601 compatible avec PHP
    const saleDate = new Date().toISOString();

    console.log("Données de la vente:", {
        sale_date: saleDate,
        total_amount: totalAmount,
        items: cartItems
    });

    try {
        const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
        const csrfToken = csrfTokenMeta ? csrfTokenMeta.content : null;

        if (!csrfToken) {
            console.error("CSRF token introuvable.");
            alert("Erreur : jeton CSRF non trouvé. Veuillez recharger la page.");
            return;
        }

        const response = await fetch('/sales', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                sale_date: saleDate,
                total_amount: totalAmount,
                items: cartItems
            })
        });

        const data = await response.json();

        if (data.success) {
            alert("Achat validé avec succès!");
            document.getElementById('ticket-body').innerHTML = '';
            cartItems = [];
        } else {
            alert("Erreur lors de l'enregistrement de la vente: " + data.message);
        }
    } catch (error) {
        console.error('Erreur:', error);
        alert("Une erreur s'est produite lors de la validation de l'achat.");
    }
}

    document.addEventListener('DOMContentLoaded', async () => {
        await fetchProducts();
        loadProducts('PM'); // Exemple de catégorie par défaut
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('modal');
    const overlay = document.getElementById('overlay');
    const openModalButton = document.getElementById('openModalButton');
    const closeButton = document.querySelector('.close-button');
    const clientTable = document.getElementById('clientTable');
    const addClientForm = document.getElementById('addClientForm');

    // Charger les clients depuis l'API
    async function loadClientsFromAPI() {
        try {
            const response = await fetch('http://gestion-de-caisse.test/api/admin/clients/grouped');
            if (!response.ok) {
                throw new Error(`Erreur lors du chargement des clients : ${response.statusText}`);
            }

            clients = await response.json();

            // Afficher les clients dans le tableau
            clientTable.innerHTML = ''; // Réinitialiser la table
            clients.forEach(client => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${client.name}</td>
                    <td>${client.adresse}</td>
                    <td>${client.tel}</td>
                    <td><button class="select-client" data-id="${client.id}">Sélectionner</button></td>
                `;
                clientTable.appendChild(row);
            });

        } catch (error) {
            console.error('Erreur :', error);
            clientTable.innerHTML = '<tr><td colspan="4">Impossible de charger les clients.</td></tr>';
        }
    }

    loadClientsFromAPI();
 

    // Ouvrir la modale
        openModalButton.addEventListener('click', function () {
        modal.classList.add('active');
        overlay.classList.add('active');

        loadClientsFromAPI();
    });

    // Fermer la modale au clic sur la croix
    closeButton.addEventListener('click', function () {
        modal.classList.remove('active');
        overlay.classList.remove('active');
    });

    // Fermer la modale en cliquant en dehors du contenu
    window.addEventListener('click', function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });

    // Sélectionner un client
    clientTable.addEventListener('click', function (e) {
        if (e.target.classList.contains('select-client')) {
            const clientId = e.target.getAttribute('data-id');
            const client = clients.find(c => c.id == clientId);

            // Simuler la création de la commande
            alert(`Commande créée pour ${client.name}`);
            
            // Envoyer au backend
            fetch('/api/commandes', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ client_id: client.id })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Commande créée:', data);
                modal.classList.remove('active');
                overlay.classList.remove('active');
            })
            .catch(error => console.error('Erreur:', error));
        }
    });

    // Ajouter un nouveau client
    addClientForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const newClient = {
            name: document.getElementById('clientName').value,
            address: document.getElementById('clientAddress').value,
            phone: document.getElementById('clientPhone').value,
        };

        // Envoyer les données au backend
        fetch('/api/clients', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(newClient),
        })
        .then(response => response.json())
        .then(data => {
            console.log('Client ajouté:', data);
            clients.push(data.client); // Ajouter le client à la liste
            loadClients(); // Mettre à jour le tableau des clients

            // Simuler la création de commande avec le nouveau client
            return fetch('/api/commandes', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ client_id: data.client.id }),
            });
        })
        .then(response => response.json())
        .then(data => {
            alert('Commande créée avec le nouveau client.');
            modal.classList.remove('active');
            overlay.classList.remove('active');
        })
        .catch(error => console.error('Erreur:', error));
    });
});

</script>

<style>
    /* Styles pour la modale */
    .lib {
        color: #fff;    
        font-size: 12px;
    }
    .deleteIcon{
        color:#fff;    
        font-size: 12px; 
    }
    .total{
        color:#fff;    
        font-size: 15px; 
    }
    .modal {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        height: 400px;
        transform: translate(-50%, -50%);
        border-radius: 8px;
        background: white;
        padding: 20px;
        border: 1px solid #ccc;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        z-index: 1000;
    }
    .modal.active {
        display: block;
    }
    .modal .close-button {
        
        margin-top: 10px;
        background: #FC6180;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
    }
    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
    }
    .overlay.active {
        display: block;
    }
    .modal h5{
        font-size: 15px;
        text-align: center;
    }
</style>

    
@endsection