import { Component, Input, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { ApiService } from 'src/app/services/api.service';

@Component({
  selector: 'app-product',
  templateUrl: './product.component.html',
  styleUrls: ['./product.component.scss']
})
export class ProductComponent implements OnInit {
  @Input()
  productDetails = { fornecedor: '', designacao: '', fabricante: '', numRef: 0, lote: '', testeEmbal: '', apres: '', precoEuro: 0, precoEscudo: 0 };
  Product: any = [];
  productData: any = {};

  constructor(public api: ApiService, public router: Router, public actRoute: ActivatedRoute,) { }

  ngOnInit(): void {
    // this.getProduct();
  }

  createProduct() {
    this.api.createProduct(this.productDetails).subscribe((data: {}) => {
      this.router.navigate(['/product']);
    });
  }

  getProduct() {
    return this.api.getProducts().subscribe((data: {}) => {
      this.Product = data;
    });
  }

  getProductId(id: any) {
    this.api.getProductsId(id).subscribe((data: {}) => {
      this.productData = data;
    });
  }

  updateProduct(id: any) {
    if(window.confirm("Are you sure, you want to update?")) {
      this.api.updateProduct(id, this.productData).subscribe(data => {
        this.router.navigate(['/product'])
      });
    }
  }

  deleteProduct(id: any){
    if(window.confirm('Are you sure, you want to delete?')) {
      this.api.deleteProduct(id).subscribe((data) => {
        this.getProduct();
      });
    }
  }
}
