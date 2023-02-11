<div>
    <nav>
        <div>
            <form class="d-flex" action="{{ route($ruta) }}" method="GET">
                <div class="input-group">
                    <!--    
                    <span class="input-group-text"><i class="tf-icons bx bx-search"></i></span>
                    <input wire:model="search" type="text" class="form-control" placeholder="Search..." />
                    <input name="search" type="text" class="form-control" placeholder="Search..." />
                    ---->
                    <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-primary" type="submit">Search</button>
                </div>
            </form>
        </div>
    </nav>
    <br>
</div>