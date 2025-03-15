@extends('layouts.admin')

@section('title')

Stock des ingredients
    
@endsection

@section('content')

<div class="main-body">
    <div class="page-wrapper">
        <div class="page-body">
            <div class="row">
              <div class="col-sm-12">
                <div class="card">
                    <div class="col-lg-12 col-xl-12">
                        <h2>Tableau de Stock des Ingrédients</h2>
                        <table border="1" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Ingrédient</th>
                                    <th>Stock Actuel</th>
                                    <th>Unité Principale</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stockData as $stockItem)
                                <tr @if($stockItem->ingredient && $stockItem->current_stock <= $stockItem->ingredient->seuil) class="low-stock" @endif>

                                        <td>{{ $stockItem->id }}</td>
                                        <td>{{ $stockItem->ingredient->designation ?? 'N/A' }}</td>
                                        <td>{{ $stockItem->current_stock }}</td>
                                        <td>{{ $stockItem->unitIngredient->main_unit }}</td>                                       
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>                       
                    </div>
                </div>

            </div>
        </div>
    </div>
        

    </div>
</div>
<div id="lowStockModal" class="modal">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <h2>Attention ! Stock faible</h2>
        <p id="lowStockMessage">Les stocks sont bas pour certains ingrédients :</p>
    </div>
</div>
   
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const lowStockItems = document.querySelectorAll('.low-stock');
    const modal = document.getElementById('lowStockModal');
    const closeButton = document.querySelector('.close-button');
    const messageContainer = document.getElementById('lowStockMessage');

    if (lowStockItems.length > 0) {
        let message = "<strong>Attention ! Les stocks sont bas pour les ingrédients suivants :</strong><br><br>";

        lowStockItems.forEach(item => {
            const ingredientName = item.querySelector('td:nth-child(2)').innerText;
            const currentStock = item.querySelector('td:nth-child(3)').innerText;
            const unitprincipale = item.querySelector('td:nth-child(4)').innerText;
            message += `${ingredientName} - Stock actuel : ${currentStock} ${unitprincipale}<br>`;
        });

        // Injecter le message dans la modale
        messageContainer.innerHTML = message;

        // Afficher la modale
        modal.style.display = "block";
    }

    // Fermer la modale au clic sur la croix
    closeButton.addEventListener('click', function () {
        modal.style.display = "none";
    });

    // Fermer la modale en cliquant en dehors du contenu
    window.addEventListener('click', function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
});

</script>
<style>
    .modal {
        display: none; /* Masqué par défaut */
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); /* Fond transparent noir */
    }

    .modal-content {
        position: relative;
        margin: 10% auto;
        padding: 20px;
        width: 60%;
        max-width: 500px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        text-align: center;
    }

    .close-button {
        position: absolute;
        top: 10px;
        right: 20px;
        font-size: 24px;
        color: #888;
        cursor: pointer;
    }

    .close-button:hover {
        color: #333;
    }

    .modal h2 {
        color: #d9534f;
        margin-bottom: 15px;
    }

    .modal p {
        font-size: 16px;
        line-height: 1.6;
    }
</style>
    
@endsection

