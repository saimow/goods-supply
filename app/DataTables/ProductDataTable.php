<?php

namespace App\DataTables;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->setRowId('id')
            ->editColumn('Name', function($row) {
                return substr($row->name, 0, 20) . '...';
            })
            ->editColumn('Price', function($row) {
                return '$'. number_format($row->price, 2);
            })
            ->editColumn('created_at', function($row) {
                return $row->created_at->format('d-m-Y H:i:s');
            })
            ->addColumn('actions', function ($row) {
                $html = "<div class='d-inline-flex'>";
                $html .= "<a href=".route('products.show', $row->slug)." target='_blank' class='btn btn-secondary btn-sm me-1'><i class='bi bi-eye-fill'></i></a>";
                $html .= "<a href=".route('admin.products.edit', $row->id)." class='btn btn-success btn-sm me-1'><i class='bi bi-pencil-fill'></i></a>";
                $html .= "<button data-id='".$row->id."' type='button' class='btn btn-danger btn-sm delete-confirmation' data-bs-toggle='modal' data-bs-target='#delete-confirmation'><i class='bi bi-trash3-fill'></i></button>";
                $html .= "</div>";
                return $html;
            })
            ->rawColumns(['actions']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('datatable')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(3)
                    ->buttons([
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('Name'),
            Column::make('Price'),
            Column::make('created_at'),
            Column::make('actions'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Product_' . date('YmdHis');
    }
}
