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
        <div
            class="mx-auto w-full max-w-2xl px-6 md:max-w-3xl lg:max-w-7xl lg:px-10 flex flex-col gap-16"
        >
            <div class="flex flex-col gap-32">
                <div class="flex flex-col items-start gap-6">
                    <h1
                        class="font-display text-5xl/12 tracking-tight text-balance sm:text-[5rem]/20 text-mauve-950 max-w-5xl"
                    >
                        Daily task notes, like a bullet journal. Free
                        forever—just sign up and start.
                    </h1>
                    <div
                        class="text-lg/8 text-mauve-700 flex max-w-3xl flex-col gap-4"
                    >
                        <p>
                            No titles, no categories, no learning curve. Just
                            open the app, write your tasks, and get on with your
                            day.
                        </p>
                    </div>
                    <a
                        class="inline-flex shrink-0 items-center justify-center gap-1 rounded-full text-sm/7 font-medium bg-mauve-950 text-white hover:bg-mauve-800 px-4 py-2"
                        href="{{ route('dashboard') }}"
                    >
                        Start your first note
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section class="py-16" id="features">
        <div
            class="mx-auto w-full max-w-2xl px-6 md:max-w-3xl lg:max-w-7xl lg:px-10 flex flex-col gap-10 sm:gap-16"
        >
            <div>
                <div class="grid grid-cols-1 gap-6">
                    <div
                        class="group grid grid-flow-dense grid-cols-1 gap-2 rounded-lg bg-mauve-950/2.5 p-2 lg:grid-cols-2"
                    >
                        <div
                            class="flex flex-col justify-between gap-6 p-6 sm:gap-10 sm:p-10 lg:p-6 lg:group-even:col-start-2"
                        >
                            <div class="text-xl/8 sm:text-2xl/9">
                                <h3 class="text-mauve-950">
                                    Notes grouped by day, automatically
                                </h3>
                                <div class="flex flex-col gap-4 text-mauve-500">
                                    <p>
                                        Start a note without naming it—we
                                        auto-title it with today's date. Today's
                                        note shows as "Today," yesterday's as
                                        "Yesterday." Create multiple notes in a
                                        day and they'll show the time instead of
                                        repeating the date. Less mental effort
                                        when reviewing your history.
                                    </p>
                                </div>
                            </div>
                            <p class="inline-flex items-center gap-2 text-sm/7 font-medium text-mauve-950">
                                This app is for planning today, not your week.
                                Past notes are always there—scroll to review
                                them like a journal.
                            </p>
                        </div>
                        <div
                            class="relative overflow-hidden rounded-sm lg:group-even:col-start-1"
                        >
                            <div
                                data-color="blue"
                                class="h-full relative overflow-hidden bg-linear-to-b data-[color=blue]:from-[#637c86] data-[color=blue]:to-[#778599] data-[color=brown]:from-[#8d7359] data-[color=brown]:to-[#765959] data-[color=green]:from-[#9ca88f] data-[color=green]:to-[#596352] data-[color=purple]:from-[#7b627d] data-[color=purple]:to-[#8f6976] group"
                                data-placement="bottom-right"
                            >
                                <div
                                    class="absolute inset-0 opacity-30 mix-blend-overlay"
                                    style="
                                        background-position: center;
                                        background-image: url(&quot;data:image/svg+xml;charset=utf-8,%20%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22250%22%20height%3D%22250%22%20viewBox%3D%220%200%20100%20100%22%3E%20%3Cfilter%20id%3D%22n%22%3E%20%3CfeTurbulence%20type%3D%22turbulence%22%20baseFrequency%3D%221.4%22%20numOctaves%3D%221%22%20seed%3D%222%22%20stitchTiles%3D%22stitch%22%20result%3D%22n%22%20%2F%3E%20%3CfeComponentTransfer%20result%3D%22g%22%3E%20%3CfeFuncR%20type%3D%22linear%22%20slope%3D%224%22%20intercept%3D%221%22%20%2F%3E%20%3CfeFuncG%20type%3D%22linear%22%20slope%3D%224%22%20intercept%3D%221%22%20%2F%3E%20%3CfeFuncB%20type%3D%22linear%22%20slope%3D%224%22%20intercept%3D%221%22%20%2F%3E%20%3C%2FfeComponentTransfer%3E%20%3CfeColorMatrix%20type%3D%22saturate%22%20values%3D%220%22%20in%3D%22g%22%20%2F%3E%20%3C%2Ffilter%3E%20%3Crect%20width%3D%22100%25%22%20height%3D%22100%25%22%20filter%3D%22url(%23n)%22%20%2F%3E%20%3C%2Fsvg%3E%20&quot;);
                                    "
                                ></div>
                                <div class="relative">
                                    <div
                                        class="relative [--padding:min(10%,--spacing(16))] group-data-[placement=bottom]:px-(--padding) group-data-[placement=bottom]:pt-(--padding) group-data-[placement=bottom-left]:pt-(--padding) group-data-[placement=bottom-left]:pr-(--padding) group-data-[placement=bottom-right]:pt-(--padding) group-data-[placement=bottom-right]:pl-(--padding) group-data-[placement=top]:px-(--padding) group-data-[placement=top]:pb-(--padding) group-data-[placement=top-left]:pr-(--padding) group-data-[placement=top-left]:pb-(--padding) group-data-[placement=top-right]:pb-(--padding) group-data-[placement=top-right]:pl-(--padding)"
                                    >
                                        <div
                                            class="*:relative *:ring-1 *:ring-black/10 group-data-[placement=bottom]:*:rounded-t-sm group-data-[placement=bottom-left]:*:rounded-tr-sm group-data-[placement=bottom-right]:*:rounded-tl-sm group-data-[placement=top]:*:rounded-b-sm group-data-[placement=top-left]:*:rounded-br-sm group-data-[placement=top-right]:*:rounded-bl-sm"
                                        >
                                            {{-- img --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="group grid grid-flow-dense grid-cols-1 gap-2 rounded-lg bg-mauve-950/2.5 p-2 lg:grid-cols-2"
                    >
                        <div
                            class="flex flex-col justify-between gap-6 p-6 sm:gap-10 sm:p-10 lg:p-6 lg:group-even:col-start-2"
                        >
                            <div class="text-xl/8 sm:text-2xl/9">
                                <h3 class="text-mauve-950">
                                    Cancel tasks, don't delete them
                                </h3>
                                <div class="flex flex-col gap-4 text-mauve-500">
                                    <p>
                                        Changed your mind about a task? Cancel it instead of deleting. It stays logged so you can see what you planned and when you decided not to do it—like crossing out on paper, but digital.
                                    </p>
                                </div>
                            </div>
                            <p class="inline-flex items-center gap-2 text-sm/7 font-medium text-mauve-950">
                                Cancelled tasks are crossed and dimmed—they stay visible but don't demand attention. Embrace your changing mind.
                            </p>
                        </div>
                        <div
                            class="relative overflow-hidden rounded-sm lg:group-even:col-start-1"
                        >
                            <div
                                data-color="blue"
                                class="h-full relative overflow-hidden bg-linear-to-b data-[color=blue]:from-[#637c86] data-[color=blue]:to-[#778599] data-[color=brown]:from-[#8d7359] data-[color=brown]:to-[#765959] data-[color=green]:from-[#9ca88f] data-[color=green]:to-[#596352] data-[color=purple]:from-[#7b627d] data-[color=purple]:to-[#8f6976] group"
                                data-placement="bottom-right"
                            >
                                <div
                                    class="absolute inset-0 opacity-30 mix-blend-overlay"
                                    style="
                                        background-position: center;
                                        background-image: url(&quot;data:image/svg+xml;charset=utf-8,%20%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22250%22%20height%3D%22250%22%20viewBox%3D%220%200%20100%20100%22%3E%20%3Cfilter%20id%3D%22n%22%3E%20%3CfeTurbulence%20type%3D%22turbulence%22%20baseFrequency%3D%221.4%22%20numOctaves%3D%221%22%20seed%3D%222%22%20stitchTiles%3D%22stitch%22%20result%3D%22n%22%20%2F%3E%20%3CfeComponentTransfer%20result%3D%22g%22%3E%20%3CfeFuncR%20type%3D%22linear%22%20slope%3D%224%22%20intercept%3D%221%22%20%2F%3E%20%3CfeFuncG%20type%3D%22linear%22%20slope%3D%224%22%20intercept%3D%221%22%20%2F%3E%20%3CfeFuncB%20type%3D%22linear%22%20slope%3D%224%22%20intercept%3D%221%22%20%2F%3E%20%3C%2FfeComponentTransfer%3E%20%3CfeColorMatrix%20type%3D%22saturate%22%20values%3D%220%22%20in%3D%22g%22%20%2F%3E%20%3C%2Ffilter%3E%20%3Crect%20width%3D%22100%25%22%20height%3D%22100%25%22%20filter%3D%22url(%23n)%22%20%2F%3E%20%3C%2Fsvg%3E%20&quot;);
                                    "
                                ></div>
                                <div class="relative">
                                    <div
                                        class="relative [--padding:min(10%,--spacing(16))] group-data-[placement=bottom]:px-(--padding) group-data-[placement=bottom]:pt-(--padding) group-data-[placement=bottom-left]:pt-(--padding) group-data-[placement=bottom-left]:pr-(--padding) group-data-[placement=bottom-right]:pt-(--padding) group-data-[placement=bottom-right]:pl-(--padding) group-data-[placement=top]:px-(--padding) group-data-[placement=top]:pb-(--padding) group-data-[placement=top-left]:pr-(--padding) group-data-[placement=top-left]:pb-(--padding) group-data-[placement=top-right]:pb-(--padding) group-data-[placement=top-right]:pl-(--padding)"
                                    >
                                        <div
                                            class="*:relative *:ring-1 *:ring-black/10 group-data-[placement=bottom]:*:rounded-t-sm group-data-[placement=bottom-left]:*:rounded-tr-sm group-data-[placement=bottom-right]:*:rounded-tl-sm group-data-[placement=top]:*:rounded-b-sm group-data-[placement=top-left]:*:rounded-br-sm group-data-[placement=top-right]:*:rounded-bl-sm"
                                        >
                                            {{-- img --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="group grid grid-flow-dense grid-cols-1 gap-2 rounded-lg bg-mauve-950/2.5 p-2 lg:grid-cols-2"
                    >
                        <div
                            class="flex flex-col justify-between gap-6 p-6 sm:gap-10 sm:p-10 lg:p-6 lg:group-even:col-start-2"
                        >
                            <div class="text-xl/8 sm:text-2xl/9">
                                <h3 class="text-mauve-950">
                                    Access anywhere
                                </h3>
                                <div class="flex flex-col gap-4 text-mauve-500">
                                    <p>
                                        Your notes sync across devices. Capture a task on your phone, review it on your laptop. Your day's plan is always with you.
                                    </p>
                                </div>
                            </div>
                            <p class="inline-flex items-center gap-2 text-sm/7 font-medium text-mauve-950">
                                Nothing to install—it's a web app. Open your browser and your notes are there.
                            </p>
                        </div>
                        <div
                            class="relative overflow-hidden rounded-sm lg:group-even:col-start-1"
                        >
                            <div
                                data-color="brown"
                                class="h-full relative overflow-hidden bg-linear-to-b data-[color=blue]:from-[#637c86] data-[color=blue]:to-[#778599] data-[color=brown]:from-[#8d7359] data-[color=brown]:to-[#765959] data-[color=green]:from-[#9ca88f] data-[color=green]:to-[#596352] data-[color=purple]:from-[#7b627d] data-[color=purple]:to-[#8f6976] group"
                                data-placement="bottom-right"
                            >
                                <div
                                    class="absolute inset-0 opacity-30 mix-blend-overlay"
                                    style="
                                        background-position: center;
                                        background-image: url(&quot;data:image/svg+xml;charset=utf-8,%20%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22250%22%20height%3D%22250%22%20viewBox%3D%220%200%20100%20100%22%3E%20%3Cfilter%20id%3D%22n%22%3E%20%3CfeTurbulence%20type%3D%22turbulence%22%20baseFrequency%3D%221.4%22%20numOctaves%3D%221%22%20seed%3D%222%22%20stitchTiles%3D%22stitch%22%20result%3D%22n%22%20%2F%3E%20%3CfeComponentTransfer%20result%3D%22g%22%3E%20%3CfeFuncR%20type%3D%22linear%22%20slope%3D%224%22%20intercept%3D%221%22%20%2F%3E%20%3CfeFuncG%20type%3D%22linear%22%20slope%3D%224%22%20intercept%3D%221%22%20%2F%3E%20%3CfeFuncB%20type%3D%22linear%22%20slope%3D%224%22%20intercept%3D%221%22%20%2F%3E%20%3C%2FfeComponentTransfer%3E%20%3CfeColorMatrix%20type%3D%22saturate%22%20values%3D%220%22%20in%3D%22g%22%20%2F%3E%20%3C%2Ffilter%3E%20%3Crect%20width%3D%22100%25%22%20height%3D%22100%25%22%20filter%3D%22url(%23n)%22%20%2F%3E%20%3C%2Fsvg%3E%20&quot;);
                                    "
                                ></div>
                                <div class="relative">
                                    <div
                                        class="relative [--padding:min(10%,--spacing(16))] group-data-[placement=bottom]:px-(--padding) group-data-[placement=bottom]:pt-(--padding) group-data-[placement=bottom-left]:pt-(--padding) group-data-[placement=bottom-left]:pr-(--padding) group-data-[placement=bottom-right]:pt-(--padding) group-data-[placement=bottom-right]:pl-(--padding) group-data-[placement=top]:px-(--padding) group-data-[placement=top]:pb-(--padding) group-data-[placement=top-left]:pr-(--padding) group-data-[placement=top-left]:pb-(--padding) group-data-[placement=top-right]:pb-(--padding) group-data-[placement=top-right]:pl-(--padding)"
                                    >
                                        <div
                                            class="*:relative *:ring-1 *:ring-black/10 group-data-[placement=bottom]:*:rounded-t-sm group-data-[placement=bottom-left]:*:rounded-tr-sm group-data-[placement=bottom-right]:*:rounded-tl-sm group-data-[placement=top]:*:rounded-b-sm group-data-[placement=top-left]:*:rounded-br-sm group-data-[placement=top-right]:*:rounded-bl-sm"
                                        >
                                            {{-- img --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="group grid grid-flow-dense grid-cols-1 gap-2 rounded-lg bg-mauve-950/2.5 p-2 lg:grid-cols-2"
                    >
                        <div
                            class="flex flex-col justify-between gap-6 p-6 sm:gap-10 sm:p-10 lg:p-6 lg:group-even:col-start-2"
                        >
                            <div class="text-xl/8 sm:text-2xl/9">
                                <h3 class="text-mauve-950">
                                    No setup, just start
                                </h3>
                                <div class="flex flex-col gap-4 text-mauve-500">
                                    <p>
                                        No titles to name, no categories to create, no workflow to learn. Sign up and start writing your first note in seconds.
                                    </p>
                                </div>
                            </div>
                            <p class="inline-flex items-center gap-2 text-sm/7 font-medium text-mauve-950">
                                This app isn't for complex organization—it's for capturing today's tasks. Need more structure? Use a heavier tool alongside this one.
                            </p>
                        </div>
                        <div
                            class="relative overflow-hidden rounded-sm lg:group-even:col-start-1"
                        >
                            <div
                                data-color="green"
                                class="h-full relative overflow-hidden bg-linear-to-b data-[color=blue]:from-[#637c86] data-[color=blue]:to-[#778599] data-[color=brown]:from-[#8d7359] data-[color=brown]:to-[#765959] data-[color=green]:from-[#9ca88f] data-[color=green]:to-[#596352] data-[color=purple]:from-[#7b627d] data-[color=purple]:to-[#8f6976] group"
                                data-placement="bottom-right"
                            >
                                <div
                                    class="absolute inset-0 opacity-30 mix-blend-overlay"
                                    style="
                                        background-position: center;
                                        background-image: url(&quot;data:image/svg+xml;charset=utf-8,%20%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22250%22%20height%3D%22250%22%20viewBox%3D%220%200%20100%20100%22%3E%20%3Cfilter%20id%3D%22n%22%3E%20%3CfeTurbulence%20type%3D%22turbulence%22%20baseFrequency%3D%221.4%22%20numOctaves%3D%221%22%20seed%3D%222%22%20stitchTiles%3D%22stitch%22%20result%3D%22n%22%20%2F%3E%20%3CfeComponentTransfer%20result%3D%22g%22%3E%20%3CfeFuncR%20type%3D%22linear%22%20slope%3D%224%22%20intercept%3D%221%22%20%2F%3E%20%3CfeFuncG%20type%3D%22linear%22%20slope%3D%224%22%20intercept%3D%221%22%20%2F%3E%20%3CfeFuncB%20type%3D%22linear%22%20slope%3D%224%22%20intercept%3D%221%22%20%2F%3E%20%3C%2FfeComponentTransfer%3E%20%3CfeColorMatrix%20type%3D%22saturate%22%20values%3D%220%22%20in%3D%22g%22%20%2F%3E%20%3C%2Ffilter%3E%20%3Crect%20width%3D%22100%25%22%20height%3D%22100%25%22%20filter%3D%22url(%23n)%22%20%2F%3E%20%3C%2Fsvg%3E%20&quot;);
                                    "
                                ></div>
                                <div class="relative">
                                    <div
                                        class="relative [--padding:min(10%,--spacing(16))] group-data-[placement=bottom]:px-(--padding) group-data-[placement=bottom]:pt-(--padding) group-data-[placement=bottom-left]:pt-(--padding) group-data-[placement=bottom-left]:pr-(--padding) group-data-[placement=bottom-right]:pt-(--padding) group-data-[placement=bottom-right]:pl-(--padding) group-data-[placement=top]:px-(--padding) group-data-[placement=top]:pb-(--padding) group-data-[placement=top-left]:pr-(--padding) group-data-[placement=top-left]:pb-(--padding) group-data-[placement=top-right]:pb-(--padding) group-data-[placement=top-right]:pl-(--padding)"
                                    >
                                        <div
                                            class="*:relative *:ring-1 *:ring-black/10 group-data-[placement=bottom]:*:rounded-t-sm group-data-[placement=bottom-left]:*:rounded-tr-sm group-data-[placement=bottom-right]:*:rounded-tl-sm group-data-[placement=top]:*:rounded-b-sm group-data-[placement=top-left]:*:rounded-br-sm group-data-[placement=top-right]:*:rounded-bl-sm"
                                        >
                                            {{-- img --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="group grid grid-flow-dense grid-cols-1 gap-2 rounded-lg bg-mauve-950/2.5 p-2 lg:grid-cols-2"
                    >
                        <div
                            class="flex flex-col justify-between gap-6 p-6 sm:gap-10 sm:p-10 lg:p-6 lg:group-even:col-start-2"
                        >
                            <div class="text-xl/8 sm:text-2xl/9">
                                <h3 class="text-mauve-950">
                                    Tap to complete
                                </h3>
                                <div class="flex flex-col gap-4 text-mauve-500">
                                    <p>
                                        Finished a task? Tap it and it's marked complete. Simple as that—no menus, no extra steps.
                                    </p>
                                </div>
                            </div>
                            <p class="inline-flex items-center gap-2 text-sm/7 font-medium text-mauve-950">
                                Tap again to uncomplete. Everything is reversible.
                            </p>
                        </div>
                        <div
                            class="relative overflow-hidden rounded-sm lg:group-even:col-start-1"
                        >
                            <div
                                data-color="blue"
                                class="h-full relative overflow-hidden bg-linear-to-b data-[color=blue]:from-[#637c86] data-[color=blue]:to-[#778599] data-[color=brown]:from-[#8d7359] data-[color=brown]:to-[#765959] data-[color=green]:from-[#9ca88f] data-[color=green]:to-[#596352] data-[color=purple]:from-[#7b627d] data-[color=purple]:to-[#8f6976] group"
                                data-placement="bottom-right"
                            >
                                <div
                                    class="absolute inset-0 opacity-30 mix-blend-overlay"
                                    style="
                                        background-position: center;
                                        background-image: url(&quot;data:image/svg+xml;charset=utf-8,%20%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22250%22%20height%3D%22250%22%20viewBox%3D%220%200%20100%20100%22%3E%20%3Cfilter%20id%3D%22n%22%3E%20%3CfeTurbulence%20type%3D%22turbulence%22%20baseFrequency%3D%221.4%22%20numOctaves%3D%221%22%20seed%3D%222%22%20stitchTiles%3D%22stitch%22%20result%3D%22n%22%20%2F%3E%20%3CfeComponentTransfer%20result%3D%22g%22%3E%20%3CfeFuncR%20type%3D%22linear%22%20slope%3D%224%22%20intercept%3D%221%22%20%2F%3E%20%3CfeFuncG%20type%3D%22linear%22%20slope%3D%224%22%20intercept%3D%221%22%20%2F%3E%20%3CfeFuncB%20type%3D%22linear%22%20slope%3D%224%22%20intercept%3D%221%22%20%2F%3E%20%3C%2FfeComponentTransfer%3E%20%3CfeColorMatrix%20type%3D%22saturate%22%20values%3D%220%22%20in%3D%22g%22%20%2F%3E%20%3C%2Ffilter%3E%20%3Crect%20width%3D%22100%25%22%20height%3D%22100%25%22%20filter%3D%22url(%23n)%22%20%2F%3E%20%3C%2Fsvg%3E%20&quot;);
                                    "
                                ></div>
                                <div class="relative">
                                    <div
                                        class="relative [--padding:min(10%,--spacing(16))] group-data-[placement=bottom]:px-(--padding) group-data-[placement=bottom]:pt-(--padding) group-data-[placement=bottom-left]:pt-(--padding) group-data-[placement=bottom-left]:pr-(--padding) group-data-[placement=bottom-right]:pt-(--padding) group-data-[placement=bottom-right]:pl-(--padding) group-data-[placement=top]:px-(--padding) group-data-[placement=top]:pb-(--padding) group-data-[placement=top-left]:pr-(--padding) group-data-[placement=top-left]:pb-(--padding) group-data-[placement=top-right]:pb-(--padding) group-data-[placement=top-right]:pl-(--padding)"
                                    >
                                        <div
                                            class="*:relative *:ring-1 *:ring-black/10 group-data-[placement=bottom]:*:rounded-t-sm group-data-[placement=bottom-left]:*:rounded-tr-sm group-data-[placement=bottom-right]:*:rounded-tl-sm group-data-[placement=top]:*:rounded-b-sm group-data-[placement=top-left]:*:rounded-br-sm group-data-[placement=top-right]:*:rounded-bl-sm"
                                        >
                                            {{-- img --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
