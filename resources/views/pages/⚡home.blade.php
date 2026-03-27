<?php

use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.landing')] class extends Component
{
    //
};
?>

<div>
    <section class="py-16" id="hero">
        <div class="mx-auto w-full max-w-2xl px-6 md:max-w-3xl lg:max-w-7xl lg:px-10 flex flex-col gap-16">
            <div class="flex flex-col gap-32">
                <div class="flex flex-col items-start gap-6">
                    <h1 class="font-display text-5xl/12 tracking-tight text-balance sm:text-[5rem]/20 text-mauve-950 max-w-5xl">
                        Daily task notes, like a bullet journal. Free forever—just sign up and start.
                    </h1>
                    <div class="text-lg/8 text-mauve-700 flex max-w-3xl flex-col gap-4">
                        <p>
                            No titles, no categories, no learning curve. Just open the app, write your tasks, and get on
                            with your day.
                        </p>
                    </div>
                    <a class="inline-flex shrink-0 items-center justify-center gap-1 rounded-full text-sm/7 font-medium bg-mauve-950 text-white hover:bg-mauve-800 px-4 py-2"
                        href="{{ route('dashboard') }}">
                        Start your first note
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section class="py-16" id="features">
        <div class="mx-auto w-full max-w-2xl px-6 md:max-w-3xl lg:max-w-7xl lg:px-10 flex flex-col gap-10 sm:gap-16">
            <div>
                <div class="grid grid-cols-1 gap-2 lg:grid-cols-2">
                    <div class="rounded-lg bg-mauve-950/2.5 p-2 ">
                        <div class="flex flex-col justify-between gap-6 p-6 sm:gap-10 sm:p-10 lg:p-6 lg:group-even:col-start-2">
                            <div class="text-xl/8 sm:text-2xl/9">
                                <h3 class="text-mauve-950">Notes grouped by day, automatically</h3>
                                <div class="text-mauve-500 ">
                                    <p>
                                        Start a note without naming it—we auto-title it with today's date. Today's note
                                        shows as "Today," yesterday's as "Yesterday." Create multiple notes in a day and
                                        they'll show the time instead of repeating the date. Less mental effort when
                                        reviewing your history.
                                    </p>
                                </div>
                            </div>
                            <p class="text-sm/7 font-medium text-mauve-950">
                                This app is for planning today, not your week. Past notes are always
                                there—scroll to review them like a journal.
                            </p>
                        </div>
                    </div>
                    <div class="rounded-lg bg-mauve-950/2.5 p-2 ">
                        <div class="flex flex-col justify-between gap-6 p-6 sm:gap-10 sm:p-10 lg:p-6 lg:group-even:col-start-2">
                            <div class="text-xl/8 sm:text-2xl/9">
                                <h3 class="text-mauve-950">Cancel tasks, don't delete them</h3>
                                <div class="text-mauve-500 ">
                                    <p>
                                        Changed your mind about a task? Cancel it instead of deleting. It stays logged so
                                        you can see what you planned and when you decided not to do it—like crossing out
                                        on paper, but digital.
                                    </p>
                                </div>
                            </div>
                            <p class="text-sm/7 font-medium text-mauve-950">
                                Cancelled tasks are crossed and dimmed—they stay visible but don't demand
                                attention. Embrace your changing mind.
                            </p>
                        </div>
                    </div>
                    <div class="rounded-lg bg-mauve-950/2.5 p-2 ">
                        <div class="flex flex-col justify-between gap-6 p-6 sm:gap-10 sm:p-10 lg:p-6 lg:group-even:col-start-2">
                            <div class="text-xl/8 sm:text-2xl/9">
                                <h3 class="text-mauve-950">Access anywhere</h3>
                                <div class="text-mauve-500 ">
                                    <p>
                                        Your notes sync across devices. Capture a task on your phone, review it on your
                                        laptop. Your day's plan is always with you.
                                    </p>
                                </div>
                            </div>
                            <p class="text-sm/7 font-medium text-mauve-950">
                                Nothing to install—it's a web app. Open your browser and your notes are
                                there.
                            </p>
                        </div>
                    </div>
                    <div class="rounded-lg bg-mauve-950/2.5 p-2 ">
                        <div class="flex flex-col justify-between gap-6 p-6 sm:gap-10 sm:p-10 lg:p-6 lg:group-even:col-start-2">
                            <div class="text-xl/8 sm:text-2xl/9">
                                <h3 class="text-mauve-950">No setup, just start</h3>
                                <div class="text-mauve-500 ">
                                    <p>
                                        No titles to name, no categories to create, no workflow to learn. Sign up and
                                        start writing your first note in seconds.
                                    </p>
                                </div>
                            </div>
                            <p class="text-sm/7 font-medium text-mauve-950">
                                This app isn't for complex organization—it's for capturing today's tasks.
                                Need more structure? Use a heavier tool alongside this one.
                            </p>
                        </div>
                    </div>
                    <div class="rounded-lg bg-mauve-950/2.5 p-2 ">
                        <div class="flex flex-col justify-between gap-6 p-6 sm:gap-10 sm:p-10 lg:p-6 lg:group-even:col-start-2">
                            <div class="text-xl/8 sm:text-2xl/9">
                                <h3 class="text-mauve-950">Tap to complete</h3>
                                <div class="text-mauve-500 ">
                                    <p>
                                        Finished a task? Tap it and it's marked complete. Simple as that—no menus, no
                                        extra steps.
                                    </p>
                                </div>
                            </div>
                            <p class="text-sm/7 font-medium text-mauve-950">
                                Tap again to uncomplete. Everything is reversible.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
