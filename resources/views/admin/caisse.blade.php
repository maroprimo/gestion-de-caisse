@extends('layouts.admincaisse')

@section('title')

Caisse vente direct
    
@endsection

@section('content')

<div class="main-body">
    <div class="page-wrapper">

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
                                    <h5>Vente directe</h5>
                                    <!-- ------------ Ticket table -------------- -->
                                    <table class="table table-ticket" id="table">
                                        <thead>
                                            <tr>
                                                <th class="lib-col">Libelle</th>
                                                <th>Prix</th>
                                                <th>Quantite</th>
                                                <th>Total</th>
                                                <th class="deleteIcon">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="ticket-body" class="ticket-body">
                                            <!-- Lignes de commande ajoutées ici -->
                                        </tbody>
                                    </table>
                                    
                                <div id="total-container">
                                    <p>Total : <span id="total-amount">$0.00</span></p>
                                </div>
                                </div>
                                

                              <div class="card-block text-center">
                                  <button class="btn btn-primary btn-outline-primary" onclick="validatePurchase()">Valider</button>
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
            <td>${name}</td>
            <td>$${validPrice}</td>
            <td><input type="number" value="1" min="1" style="width: 60px;" onchange="updateTotal(this, ${validPrice}, ${uniqueKey})"></td>
            <td><span class="total-price">${validPrice.toFixed(2)}</span></td>
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
        totalElement.textContent = `$${totalAmount.toFixed(2)}`;
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


    
@endsection