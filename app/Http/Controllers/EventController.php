<?php


namespace App\Http\Controllers;


use App\Event;
use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Services\Event\EventService;
use App\ValueObject\CreateEvent;
use App\ValueObject\UpdateEvent;
use Illuminate\Support\Facades\Session;


/**
 * Class EventController
 * @package App\Http\Controllers
 */
class EventController extends Controller
{
    /**
     *
     */
    const PREFIX_VIEW = 'events.';

    /**
     * @var EventService
     */
    private $service;

    /**
     * EventController constructor.
     * @param EventService $service
     */
    public function __construct(EventService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = $this->service->all(true);

        return view(self::PREFIX_VIEW . 'index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view(self::PREFIX_VIEW . 'create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateEventRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEventRequest $request)
    {
        try{
            $this->service->create((new CreateEvent($request)));
            return redirect()->route('events.index')->with('success','عملیات انجام شد');
        }catch(\Exception $e){
            return redirect()->route('events.index')->with('error','عملیات با مشکل مواجه شد');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Event $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        return view(self::PREFIX_VIEW . 'edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateEventRequest $request
     * @param Event $event
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        try{
            $this->service->update((new UpdateEvent($request)), $event);
            return redirect()->route('events.index')->with('success','عملیات انجام شد');
        }catch(\Exception $e){
            return redirect()->route('events.index')->with('error','عملیات با مشکل مواجه شد');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Event $event
     * @return void
     */
    public function destroy(Event $event)
    {
        try{
            $event->delete();
            Session::flash('success','عملیات انجام شد');
        } catch (\Exception $exception) {
            Session::flash('error','عملیات با مشکل مواجه شد');
        }
    }

    /**
     * @param Event $event
     * @return \Illuminate\Http\RedirectResponse
     */
    public function canceled(Event $event)
    {
        $event->update([
            'status' => Event::CANCELED,
            'updated_by' => auth()->id()
        ]);
        return redirect()->back();
    }

    /**
     * @param Event $event
     * @return \Illuminate\Http\RedirectResponse
     */
    public function success(Event $event)
    {
        $event->update([
            'status' => Event::SUCCESS,
            'updated_by' => auth()->id()
        ]);
        return redirect()->back();
    }
}
