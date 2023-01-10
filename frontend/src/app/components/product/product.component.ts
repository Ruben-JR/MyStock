import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms'

@Component({
  selector: 'app-product',
  templateUrl: './product.component.html',
  styleUrls: ['./product.component.scss']
})
export class ProductComponent implements OnInit {
  formValue !: FormGroup;

  constructor(private formBuilder: FormBuilder) { }

  ngOnInit(): void {
    this.formValue = this.formBuilder.group({
      fornecedor: [''],
      designacao: [''],
      fabricante: [''],
      numRef: [''],
      lote: [''],
      testeEmbal: [''],
      apres: [''],
      precoEuro: [''],
      precoEscudo: [''],
    })
  }
}
