<!-- Enhanced Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    
    <!-- Saldo Card -->
    @include('admin.partials.cards.balance-card')
    
    <!-- Income Card -->
    @include('admin.partials.cards.income-card')

    <!-- Expense Card -->
    @include('admin.partials.cards.expense-card')
    
    <!-- Quick Actions Card -->
    @include('admin.partials.cards.quick-actions-card')
</div>