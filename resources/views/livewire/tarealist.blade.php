<?php

use Livewire\Volt\Component;
use App\Models\Todo;


new class extends Component {
    public $todos;
    public $task = '';



    public function fetchTodos()
    {
        $user = auth()->user();
        $this->todos = $user->todos->reverse();
    }
    public function addTodo()
    {
        if($this->task != '')
        {
            $user = auth()->user();
            $user->todos()->create([
                'task' => $this->task,
                'status' => 'open'
            ]);
            $this->task = '';
            $this->fetchTodos();
        }
    }
    public function markAsDone($todoId)
{
    $todo = Todo::find($todoId);
    if($todo->status == 'done') {
        $todo->status = 'open';
    } else {
        $todo->status = 'done';
    }
    $todo->save();
    $this->fetchTodos();
}
public function delete($todoId)
{
    $todo = Todo::find($todoId);
    $todo->delete();
    $this->fetchTodos();
}
public function mount()
    {
        $this->fetchTodos();
    }
}; ?>
<div>
    <div class="flex flex-col w-full">
        <div class="grid h-20 card bg-base-300 rounded-box place-items-center">
            <input type="text" wire:model="task" wire:keydown.enter="addTodo" placeholder="Escribe tus tareas pendientes" class="input input-bordered input-info w-full max-w-xs" />
        </div>
        <div class="divider"></div>
        <div class="grid  card bg-base-300 rounded-box place-items-center">
            <table class="table">
                <thead>
                    <tr class="text-left ">
                        <th class="px-4 py-2 text-xl">#</th>
                        <th class="px-4 py-2 text-xl">Tarea</th>
                        <th class="px-4 py-2 text-xl">Estado</th>
                        <th class="px-4 py-2 text-xl">Acción</th>
                        <th class="px-4 py-2 text-xl">Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($todos as $key => $todo)
                        <tr>
                            <th>{{ $key + 1 }}</th>
                            <td>{{ $todo->task }}</td>
                            <td>
                                <span class="{{ $todo->status == 'done' ? 'text-green-500' : 'text-red-500' }}"
                                      style="{{ $todo->status == 'done' ? 'text-decoration: line-through' : '' }}">
                                    {{ $todo->status == 'done' ? 'Completado' : 'Pendiente' }}
                                </span>
                            </td>
                            <td>
                                <input type="checkbox" class="checkbox checkbox-accent"
                                       id="todo_{{ $todo->id }}"
                                       wire:change="markAsDone({{ $todo->id }})"
                                       @if ($todo->status == 'done') checked @endif />
                                <label for="todo_{{ $todo->id }}"></label>
                            </td>
                            @if ($todo->status == 'done')
                            <td>
                                <button class="btn btn-error" wire:click="delete({{ $todo->id }})">Borrar</button>
                            </td>
                            @else
                            <td>
                                <button class="btn btn-error opacity-50 cursor-not-allowed" disabled>Borrar</button>
                            </td>
                            @endif


                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-2xl text-gray-500 dark:text-gray-400">No hay tareas pendientes</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
      </div>
</div>
